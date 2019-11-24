<?php 

namespace Pxp;

class ElementBuilder extends Builder 
{

    private $element_object;
    private $element_node;
    private $class_name;
    private $xml;
    private $args;
    private $load_function;
    
    public function createObject() : ?bool
    {
        $class_name = $this->resolveClassName();
        
        // load current element's class name
        if( $class_name == false){
            return NULL;
        }
        
        // instantiate element as class name
        $this->element_object = new $class_name($this->xml, $this->args);
        
        return true;
    }
    
    public function getObject() : ?object
    {
        return $this->element_object;
    }
    
    public function setArgLoader($loader)
    {
        $this->load_function = $loader;
    }
    
    public function setElement(\DOMElement $element)
    {
        
        // get element
        $this->element_node = $element;
        
        // get xml from element
        $this->xml = $this->getXml($this->element_node);
        
        // get args from element
        $this->args = $this->getArgs($this->element_node);
        
    }
    
    public function setClassName(string $class_name)
    {
        
        $this->class_name = $class_name;
    
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
        
        // use element id attribute to load args
        if( $element->hasAttribute('id') ) {
            $element_id = $element->getAttribute('id');
            
            // allow director to specify function to load args from based on id
            if(function_exists($this->load_function)){
                $args_loaded = call_user_func($this->load_function, $element_id);
            
                // merge args
                $args = array_merge($args_loaded, $args);
            }
            
        }
        
        return $args;
    }
}