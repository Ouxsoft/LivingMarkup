<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Page;

use DomDocument;
use DOMElement;
use DOMXPath;
use phpDocumentor\Reflection\Types\Mixed_;
use SplObjectStorage;

/**
 * Interface PageDefaultInterface
 * @package LivingMarkup\Page
 */
interface PageDefaultInterface
{
    public function loadDom(array $parameters): void;

    public function __toString(): string;

    public function callHook(string $hook_name, string $options = null): bool;

    public function instantiateComponents(string $xpath_expression, string $class_name): bool;

    public function replaceDomElement(DOMElement &$element, string $new_xml): void;

    public function query(string $query, DOMElement $node = NULL);
}

/**
 * Class Page
 *
 * Features a DOM loaded from a HTML/XML document that is modified during runtime
 *
 * @package LivingMarkup\Page
 */
class Page implements PageDefaultInterface
{

    // Document Object Model (DOM)
    public $dom;

    // DOM doctype
    public $doctype;

    // DOM XPath Query object
    public $xpath;

    // instantiated Components
    public $components = [];

    // name of function called to load Component Args using element's `id` attribute
    public $arg_load_function;

    // registered includes added during output
    public $includes = [
        'js' => [],
        'css' => []
    ];

    // entities are required to avoid server side DOM parse errors
    public $entities = [
        'nbsp' => '&#160;',
        'copy' => '&#169;',
        'reg' => '&#174;',
        'trade' => '&#8482;',
        'mdash' => '&#8212;'
    ];

    // Component placeholder ID attribute
    private $element_index_attribute = '_livingMarkup_ref';

    // DomDocument LibXML debug
    private $libxml_debug = false;

    /**
     * Page constructor
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        // suppress xml parse errors unless debugging
        if (!$this->libxml_debug) {
            libxml_use_internal_errors(true);
        }

        // create a document object model
        $this->dom = new DomDocument();

        // DomDocument format output option
        $this->dom->formatOutput = true;

        // DomDocument object setting to preserve white space
        $this->dom->preserveWhiteSpace = false;

        // DomDocument strict error checking setting
        $this->dom->strictErrorChecking = false;

        // validate DOM on Parse
        $this->dom->validateOnParse = false;

        // DomDocument encoding
        $this->dom->encoding = 'UTF-8';

        // set doctype string for loading DOM
        $this->setDoctype();

        // load DOM from filename
        $this->loadDom($parameters);

    }

    /**
     * Set an HTML5 doctype string property with HTML entities (&copy; etc.) included
     *
     * @return void
     */
    public function setDoctype(): void
    {
        $entity = '';
        foreach ($this->entities as $key => $value) {
            $entity .= '<!ENTITY ' . $key . ' "' . $value . '">' . PHP_EOL;
        }

        $this->doctype = '<!DOCTYPE html [' . $entity . ']> ';
    }

    /**
     * Custom load page wrapper for server side HTML5 entity support
     * (cannot use $this->dom->loadHTMLFile as it removes HTML5 entities, such as &copy;)
     *
     * @param array $parameters
     */
    public function loadDom(array $parameters): void
    {
        // get source file as string
        if(isset($parameters['filename'])){
            $source = file_get_contents($parameters['filename']);
        } else if (isset($parameters['markup'])) {
            $source = $parameters['markup'];
        } else {
            return;
        }

        // convert source file to Document Object Model for manipulation
        // set doctype if $this->dom->doctype would not get set
        $count = 1;
        str_ireplace('<!doctype html>', $this->doctype, $source, $count);
        if ($count == 0) {
            $source = $this->doctype . $source;
            $this->dom->loadXML($source);
        } else {
            $this->dom->loadHTML($source);
        }

        // create document iterator for this dom
        $this->xpath = new DOMXPath($this->dom);
    }

    /**
     * Call Hooks
     *
     * @param string $hook_name
     * @param string|null $options
     * @return bool-
     */
    public function callHook(string $hook_name, string $options = null): bool
    {
        // set ancestors
        foreach ($this->components as $component) {
            $component->ancestors = $this->getComponentAncestorProperties($component->component_id);
        }

        if ($options == 'RETURN_CALL') {

            foreach ($this->components as $component) {

                $this->renderComponent($component->component_id);
            }

            return true;
        }

        // iterate through elements
        foreach ($this->components as $element_object) {

            // invoke Component method with options, if exists
            $element_object($hook_name);

        }

        return true;
    }

    /**
     * Get a Component ancestors' properties based on provided component_id DOMElement's ancestors
     *
     * @param $component_id
     * @return array
     */
    public function getComponentAncestorProperties(string $component_id): array
    {
        // get ancestor ids
        $ancestor_properties = [];

        $query = "//ancestor::*[@{$this->element_index_attribute}]";
        $node = $this->getDomElementByPlaceholderId($component_id);

        foreach ($this->query($query, $node) as $dom_element) {
            $ancestor_id = $dom_element->getAttribute($this->element_index_attribute);
            $ancestor_properties[] = [
                'id' => $ancestor_id,
                'tag' => $dom_element->nodeName,
                'properties' => get_object_vars($this->components[$ancestor_id])
            ];
        }

        return array_reverse($ancestor_properties);
    }

    /**
     * Gets DOMElement using component_id provided
     *
     * @param string $component_id
     * @return DOMElement
     */
    public function getDomElementByPlaceholderId(string $component_id): ?\DOMElement
    {
        // find and replace element
        $query = '//*[@' . $this->element_index_attribute . '="' . $component_id . '"]';

        foreach ($this->query($query) as $element) {
            return $element;
        }
        return null;
    }

    /**
     * XPath query for class $this->DOM property
     *
     * @param string $query
     * @param DOMElement $node
     * @return mixed
     */
    public function query(string $query, DOMElement $node = NULL)
    {
        return $this->xpath->query($query, $node);
    }

    /**
     * In DOMDocument replace DOMElement with Component->__toString() output
     *
     * @param $component_id
     * @return bool
     */
    public function renderComponent(string $component_id): bool
    {


        // get DOMElement from placeholder id
        $dom_element = $this->getDomElementByPlaceholderId($component_id);

        if (is_null($dom_element)) {
            return false;
        }

        // get Component from placeholder id
        $component = $this->getComponentById($component_id);

        // set inner xml
        $component->xml = $this->getComponentInnerXML($component->component_id);

        if (!method_exists($component, '__toString')) {
            return false;
        }

        $new_xml = $component->__toString() ?? '';

        $this->replaceDomElement($dom_element, $new_xml);

        return true;
    }

    /**
     * Get Component by placeholder id
     *
     * @param string $component_id
     * @return object
     */
    public function getComponentById(string $component_id)
    {
        if(array_key_exists($component_id, $this->components)){
            return $this->components[$component_id];
        }

        return NULL;
    }

    /**
     * Get Component inner XML
     *
     * @param $component_id
     * @return string
     */
    public function getComponentInnerXML(string $component_id): string
    {

        $xml = '';

        $dom_element = $this->getDomElementByPlaceholderId($component_id);

        $children = $dom_element->childNodes;
        foreach ($children as $child) {
            $xml .= $dom_element->ownerDocument->saveHTML($child);
        }

        return trim($xml);
    }

    /**
     * Replaces DOMElement from property DOM with contents provided
     *
     * @param DOMElement $element
     * @param string $new_xml
     */
    public function replaceDomElement(DOMElement &$element, string $new_xml): void
    {

        // create a blank document fragment
        $fragment = $this->dom->createDocumentFragment();
        $fragment->appendXML($new_xml);

        // replace parent nodes child element with new fragment
        $element->parentNode->replaceChild($fragment, $element);
    }

    /**
     * Instantiates Components from DOMElement's found during Xpath query against property DOM
     *
     * @param string $xpath_expression
     * @param string $class_name
     * @return bool
     */
    public function instantiateComponents(string $xpath_expression, string $class_name): bool
    {
        // iterate through handler's expression searching for applicable elements
        foreach ($this->query($xpath_expression) as $element) {

            // if class does not exist replace element with informative comment
            $this->instantiateComponent($element, $class_name);

        }

        return true;
    }

    /**
     * Instantiate a DOMElement as a Component using specified class_name
     *
     * @param DOMElement $element
     * @param string $class_name
     * @return bool
     */
    public function instantiateComponent(\DOMElement &$element, string $class_name): bool
    {
        // skip if placeholder already assigned
        if ($element->hasAttribute($this->element_index_attribute)) {
            return false;
        }

        // resolve class name
        $element_class_name = $class_name;

        if ($element->hasAttribute('name')) {
            $element_name = $element->getAttribute('name');
            $element_class_name = str_replace('{name}', $element_name, $class_name);
        }

        // if class does not exist add debug comment
        if (!class_exists($element_class_name)) {
            $this->replaceDomElement($element, '<!-- Handler "' . $element_class_name . '" Not Found -->');
            return false;
        }

        // get args from element and remove child arg
        $args = $this->getDomElementArgs($element);

        // instantiate element
        $element_object = new $element_class_name($args);

        // if object cannot be instantiated add debug comment
        if (!is_object($element_object)) {
            $this->replaceDomElement($element, '<!-- Handler "' . $element_class_name . '" Error -->');
            return false;
        }

        // set element object placeholder
        $element->setAttribute($this->element_index_attribute, $element_object->component_id);

        // store object with object hash key
        $this->components[$element_object->component_id] = $element_object;

        return true;
    }

    /**
     * Get DOMElement's attribute and child <args> elements and return as a single list ("args")
     *
     * @param DOMElement $element
     * @return array
     */
    private function getDomElementArgs(DOMElement &$element): array
    {
        $args = [];

        // get attributes
        if ($element->hasAttributes()) {
            foreach ($element->attributes as $name => $attribute) {
                $this->addToMinifiedList($args, $name, $attribute->value);
            }
        }

        // get child args
        $arg_elements = $element->getElementsByTagName('arg');
        // iterate in reverse threw list of arguments to avoid bug with removing
        for ($i = $arg_elements->length - 1; $i >= 0; $i--) {

            // get argument
            $arg_element = $arg_elements->item($i);

            // add item to args
            $name = $arg_element->getAttribute('name');
            $value = $arg_element->nodeValue;

            $this->addToMinifiedList($args, $name, $value);

            // remove element
            $arg_element->parentNode->removeChild($arg_element);
        }

        // use element id attribute to load args
        if ($element->hasAttribute('id')) {
            $element_id = $element->getAttribute('id');

            // allow director to specify function to load args from based on id
            if (function_exists($this->arg_load_function)) {
                $args_loaded = call_user_func($this->arg_load_function, $element_id);

                // merge args
                $args = array_merge($args_loaded, $args);
            }
        }

        return $args;
    }

    /**
     * Add to minified list where array count of 1 are turned to string
     *
     * @param array $list
     * @param string $name
     * @param string $value
     */
    public function addToMinifiedList(array &$list, string $name, string $value): void
    {

        if (!isset($list[$name])) {
            // set value
            $list[$name] = $value;
        } else if ($list[$name] == $value) {
            // if item value exists as string skip
        } else if (is_string($list[$name])) {
            // change string value to array
            $present_value = $list[$name];
            $list[$name] = [];
            array_push($list[$name], $present_value);
            array_push($list[$name], $value);
        } else if (in_array($value, $list[$name])) {
            // if item already exists return
            return;
        } else if (is_array($list[$name])) {
            // add to array
            array_push($list[$name], $value);
        }
    }

    /**
     * Returns DomDocument property as HTML
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->dom->saveHTML();
    }
}