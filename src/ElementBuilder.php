<?php 

namespace Pxp;

class ElementBuilder extends Builder 
{
    
    private $element_object;
    public $element_node;
    public $class_name;
    
    public function getObject() : ?object
    {
        return $this->element_object;
    }
    
    public function createObject() : ?bool 
    {
        $class_name = $this->resolveClassName();
        
        // load current element's class name
        if( $class_name == false){
            return NULL;
        }
        
        // get xml from element
        $xml = $this->getXml($this->element_node);
        
        // get args from element
        $args = $this->getArgs($this->element_node);
        
        // instantiate element as class name
        $this->element_object = new $class_name($xml, $args);
        
        return true;
    }
    
    // get class name
    private function resolveClassName() : ?string
    {
        
        // load class based on element name attribute
        if( $this->element_node->hasAttribute('name') ) {
            $element_name = $this->element_node->getAttribute('name');
            $this->class_name = str_replace('{name}', $element_name, $this->class_name);
        }
        
        if( ! class_exists($this->class_name) ){
            return NULL;
        }
        
        return $this->class_name;
        
    }
    
    // get element's innerXML
    private function getXml(\DOMElement $element) : string
    {
        
        $xml = '';
        
        $children = $element->childNodes;
        foreach($children as $child){
            $xml .= $element->ownerDocument->saveHTML($child);
        }
        
        return $xml;
    }
    
    // get element args
    private function getArgs(\DOMElement &$element) : array 
    {
        
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
}