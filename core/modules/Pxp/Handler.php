<?php

/*

Handler

A handler consists of a key (XPath expression) and a value (Class).
The XPath expression is used to find elements and the Class specifies how to instantiate that element once found.

The element's name attribute may be instatiated different classes (e.g. '\Templates\{name}').

*/

namespace Pxp;

interface HandlerDefaultInterface
{
    function __construct($xpath_expression, $class_name);
    function process(&$pxp_doc, \DOMElement &$element) : bool;
}

final class Handler implements HandlerDefaultInterface
{
    const VERSION = 0.1;

    public $xpath_expression;    // used to find elements 
    public $class_name;    // specifies how to instantiate that element found
    private $tmp_class_name;   // class name of the current object

    public function __construct($xpath_expression, $class_name){
        $this->xpath_expression = $xpath_expression;
        $this->class_name = $class_name;
    }

    // TODO: build elements object storage in document?

    // element process
    public function process(&$pxp_doc, \DOMElement &$element) : bool {

        // load current element's class name
        if( ! $this->classNameResolve($element) ){
            return false;
        }

        // instantiate element
        $pxp_element = $this->instantiate($element);
        
        if( ! is_object($pxp_element) ){
            $new_xml = $this->error('Not Found');
        } else  if( method_exists($pxp_element, 'view') ){
            $new_xml = $pxp_element->view();
        } else {
            $new_xml = $this->error('No Content');
        }

        // replace old element value with new xml content
        $this->replace($pxp_doc, $element, $new_xml);

        return true;
    }   

    // elements are instatiation separately because they may call different class names
    // and to clear the object properties
    private function instantiate(\DOMElement &$element) : ?object {

        // get args from element
        $args = $this->argsGet($element);

        // get xml from element
        $xml = $this->xmlGet($element);

        // instantiate element as class name
        $element_object = new $this->tmp_class_name($args, $xml);

        return $element_object;
    }

    // get class name
    private function classNameResolve(\DOMElement &$element) : bool {
        $class_name = $this->class_name;
        
        // load class based on element name attribute
        if( $element->hasAttribute('name') ) {
            $element_name = $element->getAttribute('name');
            $class_name = str_replace('{name}', $element_name, $this->class_name);
        } 

        if( ! class_exists($class_name) ){
            return false;
        }

        $this->tmp_class_name = $class_name;

        return true;
    }

    // get element's innerXML
    private function xmlGet(\DOMElement $element){

        $xml = '';

        $children = $element->childNodes;
        foreach($children as $child){
            $xml .= $element->ownerDocument->saveHTML($child);
        }
        return $xml;
    }


    // get element args
    private function argsGet(\DOMElement &$element) : array {

        $args = [];

        // get attributes
        if( $element->hasAttributes() ){
            foreach($element->attributes as $name => $attribute){
                $args[$name] = $attribute->value;
            }
        }

        // get child args
        $objects = $element->getElementsByTagName('arg');
        foreach($objects as $object) {
            $name = $object->getAttribute('name');
            $value = $object->nodeValue;
            $args[$name] = $value;
        }

        // load element ID
        if( $element->hasAttribute('id') ) {
            $element_id = $element->getAttribute('id');

            // TODO: load args
            $id_args = ['test'=>'2'];

            // merge args
            $args = array_merge($id_args, $args);
        } 
        
        return $args;
    }


    // replace element contents
    private function replace(&$document, \DOMElement &$element, string $new_xml){

        // create a blank document fragment
        $fragment = $document->createDocumentFragment();
        $fragment->appendXML($new_xml);

        // replace parent nodes child element with new fragement
        $element->parentNode->replaceChild($fragment, $element);
    }    

    // comment for errors
    private function error($type){
        return '<!-- Handler "' . $this->tmp_class_name . '" ' . $type . ' -->';
    }    
}