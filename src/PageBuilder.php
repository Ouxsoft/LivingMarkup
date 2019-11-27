<?php

namespace Pxp;

class PageEditorBuilder extends Builder
{
    private $page;
        
    public function createObject($parameters) : ?bool
    {       
        if( !isset($parameters['filename'])){
            return false;
        }
        
        $this->page = new Page($parameters['filename']);
                    
        return true;
    }
    
    public function getObject() : ?object
    {       
        return $this->page;       
    }
}