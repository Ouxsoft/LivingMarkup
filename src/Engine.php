<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup;

use DOMElement;
use DOMXPath;

/**
 * Class Engine
 *
 * Features a DOM loaded from a HTML/XML document that is modified during runtime
 *
 * @package LivingMarkup\Engine
 */
class Engine
{

    // Document Object Model (DOM)
    public $dom;

    // DOM XPath Query object
    public $xpath;

    // ComponentPool
    public $component_pool = [];

    // name of function called to load Component Args using element's `id` attribute
    public $arg_load_function;

    // registered includes added during output
    public $includes = [
        'js' => [],
        'css' => []
    ];

    // Component placeholder ID attribute
    private $element_index_attribute = '_LivingMarkup_Ref';

    /**
     * Page constructor
     *
     * @param string $source
     */
    public function __construct(string $source)
    {
        // create a document object model
        $this->dom = new Document();

        // load source to DOM
        $this->dom->loadSource($source);

        // create document iterator for this dom
        $this->xpath = new DOMXPath($this->dom);

        // create a component pool
        $this->component_pool = new ComponentPool();
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
        foreach ($this->component_pool->component as $component) {
            $component->ancestors = $this->getComponentAncestorProperties($component->component_id);
        }

        if ($options == 'RETURN_CALL') {
            foreach ($this->component_pool->component as $component) {
                $this->renderComponent($component->component_id);
            }

            return true;
        }

        // iterate through elements
        foreach ($this->component_pool->component as $element_object) {

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
                'properties' => get_object_vars($this->component_pool->component[$ancestor_id])
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
    public function query(string $query, DOMElement $node = null)
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
        if (array_key_exists($component_id, $this->component_pool->component)) {
            return $this->component_pool->component[$component_id];
        }

        return null;
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
     * Instantiates component_pool from DOMElement's found during Xpath query against property DOM
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
        $this->component_pool->component[$element_object->component_id] = $element_object;

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
        $args = new \LivingMarkup\PrunedList;

        // get attributes
        if ($element->hasAttributes()) {
            foreach ($element->attributes as $name => $attribute) {
                $args->add($name, $attribute->value);
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

            $args->add($name, $value);

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
                $args->merge($args_loaded);
            }
        }

        return $args->get();
    }

    /**
     * Returns DomDocument property as HTML5
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->dom->saveHTML();
    }
}
