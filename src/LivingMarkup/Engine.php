<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace LivingMarkup;

use LivingMarkup\Exception\Exception;
use LivingMarkup\Element\ElementPool;
use DOMElement;
use DOMNodeList;
use DOMXPath;

/**
 * Class Engine
 *
 * Runs Elements to manipulate Document
 *
 * @package LivingMarkup\Engine
 */
class Engine
{

    // marker attribute used by Engine to identify DOMElement during processing
    const INDEX_ATTRIBUTE = '_ELEMENT_ID';

    // Document Object Model (DOM)
    public $dom;

    // DOMXPath Query object
    public $xpath;

    // ElementPool
    public $element_pool;

    // registered includes added during output
    public $includes = [
        'js' => [],
        'css' => []
    ];

    /**
     * Page constructor
     *
     * @param Configuration $config
     */
    public function __construct(Configuration $config)
    {
        // create a document object model
        $this->dom = new Document();

        // load source to DOM
        $this->dom->loadSource($config->getSource());

        // create document iterator for this dom
        $this->xpath = new DOMXPath($this->dom);

        // create a element pool
        $this->element_pool = new ElementPool();
    }

    /**
     * Call Hooks
     *
     * @param array $method
     * @return bool-
     */
    public function callHook(array $method): bool
    {
        // set and/or update ancestors
        foreach ($this->element_pool as $element) {
            $element->ancestors = $this->getElementAncestorProperties($element->element_id);
        }

        // call method to all elements
        if (!array_key_exists('execute', $method)) {
            $this->element_pool->callMethod($method['name']);
            return true;
        }

        switch ($method['execute']) {
            case 'RETURN_CALL':
                foreach ($this->element_pool as $element) {
                    $this->renderElement($element->element_id);
                }
                break;
            default:
                throw new Exception('Invalid element execute command provided.');
        }

        return true;
    }

    /**
     * Get a Element ancestors' properties based on provided element_id DOMElement's ancestors
     *
     * @param $element_id
     * @return array
     */
    public function getElementAncestorProperties(string $element_id): array
    {
        // get ancestor ids
        $ancestor_properties = [];

        $query = '//ancestor::*[@' . self::INDEX_ATTRIBUTE . ']';
        $node = $this->getDomElementByPlaceholderId($element_id);

        foreach ($this->queryFetchAll($query, $node) as $dom_element) {
            $ancestor_id = $dom_element->getAttribute(self::INDEX_ATTRIBUTE);
            $ancestor_properties[] = [
                'id' => $ancestor_id,
                'tag' => $dom_element->nodeName,
                'properties' => $this->element_pool->getPropertiesById($ancestor_id)
            ];
        }

        return array_reverse($ancestor_properties);
    }

    /**
     * Gets DOMElement using element_id provided
     *
     * @param string $element_id
     * @return DOMElement|null
     */
    public function getDomElementByPlaceholderId(string $element_id): ?DOMElement
    {
        // find an element by id
        $query = '//*[@' . self::INDEX_ATTRIBUTE . '="' . $element_id . '"]';

        // get object found
        return $this->queryFetch($query);
    }

    /**
     * XPath query for class $this->DOM property that fetches all results as array
     *
     * @param string $query
     * @param DOMElement $node
     * @return mixed
     */
    public function queryFetchAll(string $query, DOMElement $node = null): ?DOMNodeList
    {
        return $this->xpath->query($query, $node);
    }

    /**
     * XPath query for class $this->DOM property that fetches only first result
     *
     * @param string $query
     * @param DOMElement $node
     * @return mixed
     */
    public function queryFetch(string $query, DOMElement $node = null): ?DOMElement
    {
        $results = $this->xpath->query($query, $node);

        if (isset($results[0])) {
            return $results[0];
        }

        return null;
    }


    /**
     * Within DOMDocument replace DOMElement with Element->__toString() output
     *
     * @param $element_id
     * @return bool
     */
    public function renderElement(string $element_id): bool
    {

        // get DOMElement from placeholder id
        $dom_element = $this->getDomElementByPlaceholderId($element_id);

        if ($dom_element===null) {
            return false;
        }

        // get element using id
        $element = $this->element_pool->getById($element_id);

        // set inner xml
        $element->xml = $this->getElementInnerXML($element->element_id);

        $new_xml = $element->__toString() ?? '';

        $this->replaceDomElement($dom_element, $new_xml);

        return true;
    }

    /**
     * Get Element inner XML
     *
     * @param $element_id
     * @return string
     */
    public function getElementInnerXML(string $element_id): string
    {
        $xml = '';

        $dom_element = $this->getDomElementByPlaceholderId($element_id);

        $children = $dom_element->childNodes;
        foreach ($children as $child) {
            $xml .= $dom_element->ownerDocument->saveHTML($child);
        }

        return $xml;
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
     * Instantiates elements from DOMElement's found during Xpath query against DOM property
     *
     * @param array $element
     * @return bool
     */
    public function instantiateElements(array $lhtml_element): bool
    {
        // check for xpath
        if (!array_key_exists('xpath', $lhtml_element)) {
            return false;
        }

        // check for class name
        if (!array_key_exists('class_name', $lhtml_element)) {
            return false;
        }

        // iterate through handler's expression searching for applicable elements
        foreach ($this->queryFetchAll($lhtml_element['xpath']) as $dom_element) {

            // if class does not exist replace element with informative comment
            $this->instantiateElement($dom_element, $lhtml_element['class_name']);
        }

        return true;
    }

    /**
     * Instantiate a DOMElement as a Element using specified class_name
     *
     * @param DOMElement $element
     * @param string $class_name
     * @return bool
     */
    private function instantiateElement(DOMElement &$element, string $class_name): bool
    {
        // skip if placeholder already assigned
        if ($element->hasAttribute(self::INDEX_ATTRIBUTE)) {
            return false;
        }

        // resolve $class_name {name} variable if present using $element
        if (strpos($class_name, '{name}') !== false) {
            if ($element->hasAttribute('name')) {
                $element_name = $element->getAttribute('name');
                $class_name = str_replace('{name}', $element_name, $class_name);
            } else {
                $this->replaceDomElement($element, '<!-- Element "' . $class_name . '" Missing Name Attribute -->');
                return false;
            }
        }

        // if class does not exist add debug comment
        if (!class_exists($class_name)) {
            $this->replaceDomElement($element, '<!-- Element "' . $class_name . '" Not Found -->');
            return false;
        }

        // get args from element and remove child arg
        $args = $this->getElementArgs($element);

        // instantiate element
        $element_object = new $class_name($args);

        // if object cannot be instantiated add debug comment
        if (!is_object($element_object)) {
            $this->replaceDomElement($element, '<!-- Element "' . $class_name . '" Error -->');
            return false;
        }

        // set element object placeholder
        $element->setAttribute(self::INDEX_ATTRIBUTE, $element_object->element_id);

        // add element to pool
        $this->element_pool->add($element_object);

        return true;
    }

    /**
     * Get DOMElement's attribute and child <args> elements and return as a single list
     * items within the list are called args as they are passed as parameters to element methods
     *
     * @param DOMElement $element
     * @return ArgumentArray
     */
    public function getElementArgs(DOMElement &$element): ArgumentArray
    {
        $args = new ArgumentArray;

        // set attributes belonging to DOMElement as args
        if ($element->hasAttributes()) {
            foreach ($element->attributes as $name => $attribute) {
                $args[$name] = $attribute->value;
            }
        }

        // get all direct child arg DOMElements
        $arg_elements = $this->queryFetchAll('arg', $element);

        // set arg DOMElements as args
        foreach ($arg_elements as $child_node) {
            $name = $child_node->getAttribute('name');

            // an arg must have a name
            if (($name === null) || ($name == '')) {
                continue;
            }

            // get value
            $value = $child_node->nodeValue;

            // get type
            $type = $child_node->getAttribute('type') ?? 'string';

            // perform type juggling
            $value = $this->setType($value, $type);

            // add item to args
            $args[$name] = $value;

            // remove element
            $child_node->parentNode->removeChild($child_node);
        }

        return $args;
    }

    /**
     * Set a value type to avoid Type Juggling issues and extend data types
     *
     * @param string $value
     * @param string $type
     * @return bool|mixed|string|null
     */
    public function setType($value = null, $type = 'string')
    {
        $type = strtolower($type);

        switch ($type) {
            case 'string':
            case 'str':
                $value = (string) $value;;
                break;
            case 'json':
                $value = json_decode($value);
                break;
            case 'int':
            case 'integer':
                $value = (int) $value;
                break;
            case 'float':
                $value = (float) $value;
                break;
            case 'bool':
            case 'boolean':
                $value = (boolean) $value;
                break;
            case 'null':
                $value = null;
                break;
            case 'list':
                $value = explode(',', $value);
                break;
            default:
                // no transform
                break;
        }

        return $value;
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
