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

use DOMElement;
use DOMNodeList;
use DOMXPath;

/**
 * Class Engine
 *
 * Runs Modules to manipulate Document
 *
 * @package LivingMarkup\Engine
 */
class Engine
{

    // Document Object Model (DOM)
    public $dom;

    // DOMXPath Query object
    public $xpath;

    // ModulePool
    public $modules;

    // registered includes added during output
    public $includes = [
        'js' => [],
        'css' => []
    ];

    /**
     * Page constructor
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

        // create a module pool
        $this->modules = new ModulePool();
    }

    /**
     * Call Hooks
     * @param array $method
     * @return bool-
     */
    public function callHook(array $method): bool
    {
        // set ancestors
        foreach ($this->modules->module as $module) {
            $module->ancestors = $this->getModuleAncestorProperties($module->module_id);
        }

        if (array_key_exists('execute', $method) && ($method['execute'] == 'RETURN_CALL')) {
            foreach ($this->modules->module as $module) {
                $this->renderModule($module->module_id);
            }

            return true;
        }

        $this->modules->callMethod($method['name']);

        return true;
    }

    /**
     * Get a Module ancestors' properties based on provided module_id DOMElement's ancestors
     * @param $module_id
     * @return array
     */
    public function getModuleAncestorProperties(string $module_id): array
    {
        // get ancestor ids
        $ancestor_properties = [];

        $query = '//ancestor::*[@' . $this->modules::INDEX_ATTRIBUTE . ']';
        $node = $this->getDomElementByPlaceholderId($module_id);

        foreach ($this->queryFetchAll($query, $node) as $dom_element) {
            $ancestor_id = $dom_element->getAttribute($this->modules::INDEX_ATTRIBUTE);
            $ancestor_properties[] = [
                'id' => $ancestor_id,
                'tag' => $dom_element->nodeName,
                'properties' => get_object_vars($this->modules->module[$ancestor_id])
            ];
        }

        return array_reverse($ancestor_properties);
    }

    /**
     * Gets DOMElement using module_id provided
     * @param string $module_id
     * @return DOMElement|null
     */
    public function getDomElementByPlaceholderId(string $module_id): ?DOMElement
    {
        // find an element by id
        $query = '//*[@' . $this->modules::INDEX_ATTRIBUTE . '="' . $module_id . '"]';

        // get object found
        return $this->queryFetch($query);
    }

    /**
     * XPath query for class $this->DOM property that fetches all results as array
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
     * @param string $query
     * @param DOMElement $node
     * @return mixed
     */
    public function queryFetch(string $query, DOMElement $node = null): ?DOMElement
    {
        $results = $this->xpath->query($query, $node);

        if(isset($results[0])){
            return $results[0];
        }

        return null;
    }


    /**
     * Within DOMDocument replace DOMElement with Module->__toString() output
     * @param $module_id
     * @return bool
     */
    public function renderModule(string $module_id): bool
    {

        // get DOMElement from placeholder id
        $dom_element = $this->getDomElementByPlaceholderId($module_id);

        if ($dom_element===null) {
            return false;
        }

        // get module using id
        $module = $this->modules->getById($module_id);

        // set inner xml
        $module->xml = $this->getModuleInnerXML($module->module_id);

        if (!method_exists($module, '__toString')) {
            return false;
        }

        $new_xml = $module->__toString() ?? '';

        $this->replaceDomElement($dom_element, $new_xml);

        return true;
    }

    /**
     * Get Module inner XML
     * @param $module_id
     * @return string
     */
    public function getModuleInnerXML(string $module_id): string
    {
        $xml = '';

        $dom_element = $this->getDomElementByPlaceholderId($module_id);

        $children = $dom_element->childNodes;
        foreach ($children as $child) {
            $xml .= $dom_element->ownerDocument->saveHTML($child);
        }

        return $xml;
    }

    /**
     * Replaces DOMElement from property DOM with contents provided
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
     * Instantiates modules from DOMElement's found during Xpath query against DOM property
     * @param array $module
     * @return bool
     */
    public function instantiateModules(array $module): bool
    {
        // check for xpath
        if (!array_key_exists('xpath', $module)) {
            return false;
        }

        // check for class name
        if (!array_key_exists('class_name', $module)) {
            return false;
        }

        // iterate through handler's expression searching for applicable elements
        foreach ($this->queryFetchAll($module['xpath']) as $element) {

            // if class does not exist replace element with informative comment
            $this->instantiateModule($element, $module['class_name']);
        }

        return true;
    }

    /**
     * Instantiate a DOMElement as a Module using specified class_name
     * @param DOMElement $element
     * @param string $class_name
     * @return bool
     */
    public function instantiateModule(DOMElement &$element, string $class_name): bool
    {
        // skip if placeholder already assigned
        if ($element->hasAttribute($this->modules::INDEX_ATTRIBUTE)) {
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
        $args = $this->getElementArgs($element);

        // instantiate element
        $element_object = new $element_class_name($args);

        // if object cannot be instantiated add debug comment
        if (!is_object($element_object)) {
            $this->replaceDomElement($element, '<!-- Handler "' . $element_class_name . '" Error -->');
            return false;
        }

        // set element object placeholder
        $element->setAttribute($this->modules::INDEX_ATTRIBUTE, $element_object->module_id);

        // add module to pool
        $this->modules->add($element_object);

        return true;
    }

    /**
     * Get DOMElement's attribute and child <args> elements and return as a single list
     * items within the list are called args as they are passed as parameters to module methods
     *
     * @param DOMElement $element
     * @return array
     */
    public function getElementArgs(DOMElement &$element): array
    {
        $args = new ArgumentArray;

        // set attributes belonging to DOMElement as args
        if ($element->hasAttributes()) {
            foreach ($element->attributes as $name => $attribute) {
                $args[$name] = $attribute->value;
            }
        }

        // get direct arg child elements
        $arg_elements = $this->queryFetchAll('arg', $element);

        // set arg DOMElements as args
        foreach ($arg_elements as $child_node) {
            $name = $child_node->getAttribute('name');

            // an arg must have a name
            if ($name === null) {
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

        return $args->get();
    }

    /**
     * Set a value type to avoid Type Juggling issues and extend data types
     * @param string $value
     * @param string $type
     * @return bool|mixed|string
     */
    public function setType($value = '', $type = 'string')
    {
        switch ($type) {
            case 'string':
            case 'str':
                $value = settype($value, 'string');
                break;
            case 'json':
                $value = json_decode($value);
                break;
            case 'int':
            case 'integer':
                $value = settype($value, 'integer');
                break;
            case 'float':
                $value = settype($value, 'float');
                break;
            case 'bool':
            case 'boolean':
                $value = settype($value, 'boolean');
                break;
            case 'null':
                $value = null;
                break;
            case 'list':
                $value = explode(',', $value);
                break;
        }

        return $value;
    }


    /**
     * Returns DomDocument property as HTML5
     * @return string
     */
    public function __toString(): string
    {
        return $this->dom->saveHTML();
    }
}
