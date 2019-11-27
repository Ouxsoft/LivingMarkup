<?php

namespace Pxp;

class PageBuilder extends Builder
{
    private $page;
        
    public function createObject($parameters) : ?bool
    {       
        if( !isset($parameters['filename'])){
            return false;
        }
        
        $this->page = new Page($parameters['filename']);
        
        // instantiate dynamic elements
        if(is_array($parameters['handlers'])){
            foreach($parameters['handlers'] as $xpath_expression => $class_name){
                $this->page->instantiateElement($xpath_expression, $class_name);
            }
        }

        // call hooks
        if(is_array($parameters['hooks'])){
            foreach($parameters['hooks'] as $name => $description){
                $this->page->callHook($name, $description);
            }
        }
            
        return true;
    }
    
    public function getObject() : ?object
    {       
        return $this->page;       
    }
}