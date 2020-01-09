<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pxp\Page;

use DomDocument;
use DOMElement;
use DOMXPath;
use phpDocumentor\Reflection\Types\Mixed_;
use SplObjectStorage;

/**
 * Interface PageDefaultInterface
 * @package Pxp\Page
 */
interface PageDefaultInterface
{
    public function loadDom(string $filepath): void;

    public function __toString(): string;

    public function callHook(string $hook_name, string $options = null): bool;

    public function instantiateDynamicElements(string $xpath_expression, string $class_name): bool;

    public function replaceDomElement(DOMElement &$element, string $new_xml): void;

    public function query(string $query, DOMElement $node = NULL);
}

/**
 * Class Page
 *
 * Features a DOM loaded from a HTML/XML document that is modified during runtime
 *
 * @package Pxp\Page
 */
class Page implements PageDefaultInterface
{

    // Document Object Model (DOM)
    public $dom;

    // DOM doctype
    public $doctype;

    // DOM XPath Query object
    public $xpath;

    // instantiated DynamicElements
    public $dynamic_elements = [];

    // name of function called to load DynamicElement Args using element's `id` attribute
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

    // DynamicElement placeholder ID attribute
    private $element_index_attribute = '_pxp_ref';

    // DomDocument LibXML debug
    private $libxml_debug = false;

    /**
     * Page constructor
     *
     * @param null $filename
     */
    public function __construct($filename = null)
    {

        // create a document object model
        $this->dom = new DomDocument();

        // DomDocument object setting to preserve white space
        $this->dom->preserveWhiteSpace = false;

        // DomDocument format output option
        $this->dom->formatOutput = true;

        // DomDocument strict error checking setting
        $this->dom->strictErrorChecking = false;

        // validate DOM on Parse
        $this->dom->validateOnParse = false;

        // DomDocument encoding
        $this->dom->encoding = 'UTF-8';

        // suppress xml parse errors unless debugging
        if (!$this->libxml_debug) {
            libxml_use_internal_errors(true);
        }

        // return if filename missing
        if ($filename == null) {
            return;
        }

        // set doctype string for loading DOM
        $this->setDoctype();

        // load DOM from filename
        $this->loadDom($filename);
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
     * @param string $filepath
     */
    public function loadDom(string $filepath): void
    {
        // get source file as string
        $source = file_get_contents($filepath);

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
     * @return bool
     */
    public function callHook(string $hook_name, string $options = null): bool
    {
        // set ancestors
        foreach ($this->dynamic_elements as $dynamic_element) {
            $dynamic_element->ancestors = $this->getDynamicElementAncestorProperties($dynamic_element->dynamic_element_id);
        }

        if ($options == 'RETURN_CALL') {

            foreach ($this->dynamic_elements as $dynamic_element) {

                $this->renderDynamicElement($dynamic_element->dynamic_element_id);
            }

            return true;
        }

        // iterate through elements
        foreach ($this->dynamic_elements as $element_object) {

            // invoke DynamicElement method with options, if exists
            $element_object($hook_name);

        }
        return true;
    }

    /**
     * Get a DynamicElement parent properties based on dynamic_element_id DOMElement ancestors
     *
     * @param $dynamic_element_id
     * @return array
     */
    public function getDynamicElementAncestorProperties(string $dynamic_element_id): array
    {

        $parent_vars = [];

        $ancestor_dynamic_element_ids = $this->getDomElementAncestorPlaceholderIds($dynamic_element_id);

        foreach ($ancestor_dynamic_element_ids as $ancestor_dynamic_element_id) {
            $dynamic_element_vars = $this->getDynamicElementProperties($ancestor_dynamic_element_id);

            $parent_vars = $parent_vars + $dynamic_element_vars;

        }

        return $parent_vars;
    }

    /**
     * Gets DynamicElement ancestors that are DynamicElement within DOM structure
     * @param string $dynamic_element_id
     * @return array
     */
    public function getDomElementAncestorPlaceholderIds(string $dynamic_element_id): array
    {
        $parent_ids = [];

        $query = "//ancestor::*[@{$this->element_index_attribute}]";
        $node = $this->getDomElementByPlaceholderId($dynamic_element_id);

        foreach ($this->query($query, $node) as $dom_element) {
            $parent_ids[] = $dom_element->getAttribute($this->element_index_attribute);

        }

        return $parent_ids;
    }

    /**
     * Gets DOMElement using dynamic_element_id provided
     *
     * @param string $dynamic_element_id
     * @return DOMElement
     */
    public function getDomElementByPlaceholderId(string $dynamic_element_id): ?\DOMElement
    {
        // find and replace element
        $query = '//*[@' . $this->element_index_attribute . '="' . $dynamic_element_id . '"]';

        foreach ($this->query($query) as $element) {
            return $element;
        }
        return null;
    }

    /**
     * XPath query for class $this->DOM property
     *
     * @param $query
     * @param null $node
     * @return mixed
     */
    public function query(string $query, DOMElement $node = NULL)
    {
        return $this->xpath->query($query, $node);
    }

    /**
     * Get DynamicElement public properties via dynamic_element_id
     *
     * @param string $dynamic_element_id
     * @return array
     */
    public function getDynamicElementProperties(string $dynamic_element_id): array
    {

        // doesn't appear to be a quicker way using SLPObject
        foreach ($this->dynamic_elements as $element) {
            if ($dynamic_element_id != $element->dynamic_element_id) {
                continue;
            }
            return get_object_vars($element);
        }

        return [];
    }

    /**
     * In DOMDocument replace DOMElement with DynamicElement->__toString() output
     *
     * @param $dynamic_element_id
     * @return bool
     */
    public function renderDynamicElement($dynamic_element_id): bool
    {


        // get DOMElement from placeholder id
        $dom_element = $this->getDomElementByPlaceholderId($dynamic_element_id);

        if (is_null($dom_element)) {
            return false;
        }

        // get DynamicElement from placeholder id
        $dynamic_element = $this->getDynamicElementByPlaceHolderId($dynamic_element_id);

        // set inner xml
        $dynamic_element->xml = $this->getDynamicElementInnerXML($dynamic_element->dynamic_element_id);

        if (!method_exists($dynamic_element, '__toString')) {
            return false;
        }

        $new_xml = $dynamic_element->__toString() ?? '';

        $this->replaceDomElement($dom_element, $new_xml);

        return true;
    }

    /**
     * Get DynamicElement by placeholder id
     *
     * @param string $dynamic_element_id
     * @return object
     */
    public function getDynamicElementByPlaceholderId(string $dynamic_element_id)
    {
        if(array_key_exists($dynamic_element_id, $this->dynamic_elements)){
            return $this->dynamic_elements[$dynamic_element_id];
        }

        return NULL;
    }

    /**
     * Get DynamicElement inner XML
     *
     * @param $dynamic_element_id
     * @return string
     */
    public function getDynamicElementInnerXML($dynamic_element_id): string
    {

        $xml = '';

        $dom_element = $this->getDomElementByPlaceholderId($dynamic_element_id);

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
     * Get DynamicElement public property via dynamic_element_id
     *
     * @param string $dynamic_element_id
     * @param string $property
     * @return mixed|null
     */
    public function getDynamicElementProperty(string $dynamic_element_id, string $property)
    {

        $properties = $this->getDynamicElementProperties($dynamic_element_id);

        if (!isset($properties[$property])) {
            return NULL;
        }

        return $properties[$property];
    }

    /**
     * Instantiates DynamicElements from DOMElement's found during Xpath query against property DOM
     *
     * @param string $xpath_expression
     * @param string $class_name
     * @return bool
     */
    public function instantiateDynamicElements(string $xpath_expression, string $class_name): bool
    {
        // iterate through handler's expression searching for applicable elements
        foreach ($this->query($xpath_expression) as $element) {

            // if class does not exist replace element with informative comment
            $this->instantiateDynamicElement($element, $class_name);

        }

        return true;
    }

    /**
     * Instantiate a DOMElement as a DynamicElement using specified class_name
     *
     * @param DOMElement $element
     * @param string $class_name
     * @return bool
     */
    public function instantiateDynamicElement(\DOMElement &$element, string $class_name): bool
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
        $element->setAttribute($this->element_index_attribute, $element_object->dynamic_element_id);

        // store object with object hash key
        $this->dynamic_elements[$element_object->dynamic_element_id] = $element_object;

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