<?php

namespace Pxp\Page\Builder;

class StaticBuilder extends Builder
{
    private $page;
        
    public function createObject($parameters) : ?bool
    {       
        if( !isset($parameters['filename'])){
            return false;
        }
        
        $this->page = new Pxp\Page\Page($parameters['filename']);
                    
        return true;
    }
    
    public function getObject() : ?object
    {       
        return $this->page;       
    }
}