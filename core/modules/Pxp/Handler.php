<?php

/*

Tag Handlers

A tag handler consists of a key (XPath expression) and a value (Class).
The XPath expression is used to find elements and the Class specifies how to instantiate that element once found.
The same tag may be instatiated using different classes provided the element's name attribute is in the class (e.g. '\Templates\{name}').
*/


namespace Pxp;

interface HandlerDefaultInterface
{
}

final class Handler implements HandlerDefaultInterface
{
    const VERSION = 0.1;

    public $xpath_expression;    // the XPath expression is used to find elements 
    public $class_name;    // the Class Name specifies how to instantiate that element found

    private $class_name_temp;

    function __construct(&$pxp_doc, $xpath_expression, $class_name){
        $this->pxp_doc = $pxp_doc;
        $this->xpath_expression = $xpath_expression;
        $this->class_name = $class_name;
    }

    // get class name
    function elementClassNameGet(\DOMElement &$element) : string {
        // load class based on element name attribute
        if( $element->hasAttribute('name') ) {
            $element_name = $element->getAttribute('name');
            return str_replace('{name}', $element_name, $this->class_name);
        } 

        return $this->class_name;
    }

    
    // TODO: load class based on id? or may be args?
    function elementArgsGet(\DOMElement &$element) : array {
        // get args from element
        $args = $this->pxp_doc->argsGetFromElement($element);

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

    // Elements are instatiation separately because they may call different class names
    // and to clear the object properties
    function elementInstantiate(\DOMElement &$element) : ?object {

        // if class exists return name
        if( ! class_exists($this->class_name_temp) ){
            return NULL;
        }

        $args = $this->elementArgsGet($element);

        // get xml version of element
        $xml = $this->pxp_doc->innerXML($element);

        // instantiate element as class name
        $element_object = new $this->class_name_temp($args, $xml);

        return $element_object;
    }

    // comment for errors
    function error($type){
        return '<!-- Handler "' . $this->class_name_temp . '" ' . $type . ' -->';
    }

    // element process
    function elementProcess(\DOMElement &$element) : string {
        
        // instantiate element 
        $this->class_name_temp = $this->elementClassNameGet($element);

        // instantiate element
        $pxp_element = $this->elementInstantiate($element);

        if( ! is_object($pxp_element) ){
            return $this->error('Not Found');
        }
        
        if( method_exists($pxp_element, 'view') ){
            return $pxp_element->view();
        } 

        return $this->error('No Content');
    }   
}