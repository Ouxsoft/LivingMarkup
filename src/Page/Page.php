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

    public function instantiateElements(string $xpath_expression, string $class_name): bool;

    public function replaceDomElement(DOMElement &$element, string $new_xml): void;

    public function query($query);
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
    public $element_objects;

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

        // objects containing elements
        $this->element_objects = new SplObjectStorage();

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
     * Gets ordered list of DynamicElement's parent's placeholder_id / object hashes
     *
     * @param string $placeholder_id
     * @return array
     */
    public function getDomElementParents(string $placeholder_id): array
    {

        $parent_ids = [];

        // find and replace element
        $query = '//*[@' . $this->element_index_attribute . '="' . $placeholder_id . '"]/ancestor::*';

        foreach ($this->query($query) as $element) {

            if ($element->hasAttribute($this->element_index_attribute)) {
                $parent_ids[] = $element->getAttribute($this->element_index_attribute);
            }

        }

        return $parent_ids;
    }

    /**
     * Get DynamicElement public property via placeholder_id
     *
     * @param string $placeholder_id
     * @param string $property
     * @return mixed|null
     */
    public function getDynamicElementProperty(string $placeholder_id, string $property)
    {

        $properties = $this->getDynamicElementProperties($placeholder_id);

        if (!isset($properties[$property])) {
            return NULL;
        }

        return $properties[$property];
    }


    /**
     * Get DynamicElement public properties via placeholder_id
     *
     * @param string $placeholder_id
     * @return array
     */
    public function getDynamicElementProperties(string $placeholder_id): array
    {

        // doesn't appear to be a quicker way using SLPObject
        foreach ($this->element_objects as $element) {
            if ($placeholder_id != $element->placeholder_id) {
                continue;
            }
            return get_object_vars($element);
        }

        return [];
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
     * Gets DOMElement using placeholder_id provided
     *
     * @param string $placeholder_id
     * @return DOMElement
     */
    public function getDomElementByPlaceholderId(string $placeholder_id): ?\DOMElement
    {
        // find and replace element
        $query = '//*[@' . $this->element_index_attribute . '="' . $placeholder_id . '"]';

        foreach ($this->query($query) as $element) {
            return $element;
        }
        return null;
    }

    /**
     * In DOMDocument replace DOMElement with DynamicElement->__toString() output
     *
     * @param $placeholder_id
     * @return bool
     */
    public function renderDynamicElement($placeholder_id) : bool {


        // get DOMElement from placeholder id
        $dom_element = $this->getDomElementByPlaceholderId($placeholder_id);

        if (is_null($dom_element)) {
            return false;
        }

        // get DynamicElement from placeholder id
        $dynamic_element = $this->getDynamicElementByPlaceHolderId($placeholder_id);

        // set inner xml
        $dynamic_element->xml = $this->getDynamicElementInnerXML($dynamic_element->placeholder_id);


        if (!method_exists($dynamic_element, '__toString')) {
            return false;
        }

        $new_xml = $dynamic_element->__toString() ?? '';

        $this->replaceDomElement($dom_element, $new_xml);

        return true;
    }

    /**
     * Update DynamicElement public ancestors properties
     */
    public function updateDynamicElementAncestors() : void {
        // iterate through elements
        foreach ($this->element_objects as $dynamic_element) {

            // set element ancestor variables
            $dynamic_element->ancestors = $this->getDynamicElementAncestorProperties($dynamic_element->placeholder_id);
        }
    }

    function getDynamicElementInnerXML($placeholder_id) : string {

        $xml = '';

        $dom_element = $this->getDomElementByPlaceholderId($placeholder_id);

        $children = $dom_element->childNodes;
        foreach ($children as $child) {
            $xml .= $dom_element->ownerDocument->saveHTML($child);
        }

        return trim($xml);
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
        // update DynamicElement reference info
        $this->updateDynamicElementAncestors();

        if ($options == 'RETURN_CALL') {

            $placeholder_ids = $this->getDynamicElementsPlaceholderIds();

            foreach ($placeholder_ids as $placeholder_id) {
                $this->renderDynamicElement($placeholder_id);
            }

            return true;
        }

        // iterate through elements
        foreach ($this->element_objects as $element_object) {

            // invoke DynamicElement method with options, if exists
            $this->invokeDynamicElementMethod($element_object, $hook_name);

        }
        return true;
    }

    /**
     * Get a DynamicElement parent properties based on placeholder_id DOMElement ancestors
     *
     * @param $placeholder_id
     * @return array
     */
    public function getDynamicElementAncestorProperties($placeholder_id) : array {

        $parent_vars = [];

        $parent_placeholder_ids = $this->getDomElementParents($placeholder_id);

        foreach ($parent_placeholder_ids as $parent_placeholder_id)
        {
            $dynamic_element_vars = $this->getDynamicElementProperties($parent_placeholder_id);
            $parent_vars = array_merge($parent_vars, $dynamic_element_vars);
        }

        return $parent_vars;
    }

    /**
     * Invoke wrapper call to instantiated DynamicElement method
     *
     * @param $dynamic_element
     * @param string $method
     * @return bool
     */
    public function invokeDynamicElementMethod($dynamic_element, string $method): bool
    {

        // if method does not exist, return
        if (!method_exists($dynamic_element, $method)) {
            return false;
        }

        // call element method
        call_user_func([
            $dynamic_element,
            $method
        ]);

        return true;
    }

    /**
     * Get DynamicElements placeholder_id list in order of appearance within DOM.
     * It is essential to replace in reverse order of appearance
     *
     * @param bool $reverse
     * @return array
     */
    public function getDynamicElementsPlaceholderIds(bool $reverse = false): array
    {
        $element_indexes = [];

        $query = '//*[@' . $this->element_index_attribute . ']';

        foreach ($this->query($query) as $element) {
            $element_indexes[] = $element->getAttribute($this->element_index_attribute);
        }

        // provide reverse option, used for render
        if ($reverse) {
            $element_indexes = array_reverse($element_indexes);
        }

        return $element_indexes;
    }

    /**
     * Get DynamicElement by placeholder id
     *
     * @param string $placeholder_id
     * @return object
     */
    public function getDynamicElementByPlaceholderId(string $placeholder_id)
    {
        foreach ($this->element_objects as $element) {
            if ($placeholder_id != $element->placeholder_id) {
                continue;
            }
            return $element;
        }
    }

    /**
     * Instantiate a DOMElement as a DynamicElement using specified class_name
     *
     * @param DOMElement $element
     * @param string $class_name
     * @return bool
     */
    public function instantiateElement(\DOMElement &$element, string $class_name): bool
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
        $args = $this->getArgs($element);

        // instantiate element
        $element_object = new $element_class_name($args);

        // if object cannot be instantiated add debug comment
        if (!is_object($element_object)) {
            $this->replaceDomElement($element, '<!-- Handler "' . $element_class_name . '" Error -->');
            return false;
        }

        // set element object placeholder
        $element->setAttribute($this->element_index_attribute, $element_object->placeholder_id);

        // store object
        $this->element_objects->attach($element_object);

        return true;
    }

    /**
     * Instantiates DynamicElements from DOMElement's found during Xpath query against property DOM
     *
     * @param string $xpath_expression
     * @param string $class_name
     * @return bool
     */
    public function instantiateElements(string $xpath_expression, string $class_name): bool
    {
        // iterate through handler's expression searching for applicable elements
        foreach ($this->query($xpath_expression) as $element) {

            // if class does not exist replace element with informative comment
            $this->instantiateElement($element, $class_name);

        }

        return true;
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
     * Get DOMElement's attribute and child <args> elements and return as a single list ("args")
     *
     * @param DOMElement $element
     * @return array
     */
    private function getArgs(DOMElement &$element): array
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
     * XPath query for class $this->DOM property
     *
     * @param $query
     * @return mixed
     */
    public function query($query)
    {
        return $this->xpath->query($query);
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