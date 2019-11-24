<?php 

namespace Pxp;

interface ElementDefaultInterface
{
    const MAX_RESULTS = '240';
    
    public function __construct($xml, $args);
    public function onRender();
    public function __toString();
}

abstract class Element implements ElementDefaultInterface
{

    public $placeholder_id = 0; // used to placeholder for PageBuilder::replaceElement()
    public $id = 0; // id used to load args
    public $name = 'unknown'; // name of element
    public $xml; // inner content on load
    public $args = []; // args passed to during constrcution
    public $tags = []; // tags
    public $search_index = true;
    
    // extending class must define this method
    abstract public function onRender();

    // get any argments set in element passed by Pxp\Document
    public function __construct($xml, $args){
        $this->xml = $xml;
        $this->args = $args;
        
        // assign object id to xml
        $this->placeholder_id = spl_object_hash($this);
        
    }

    // alias for onRender
    public function __toString(){
        if( method_exists($this,'onRender') ){
            return $this->onRender();
        }
    }
}