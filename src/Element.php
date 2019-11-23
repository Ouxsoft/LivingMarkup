<?php 

namespace Pxp;

interface ElementDefaultInterface
{
    const MAX_RESULTS = '240';
    
    public function onRender();
    public function __toString();
}

abstract class Element implements ElementDefaultInterface
{

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
    }

    public function __toString(){
        // view
        if( method_exists($this,'view') ){
            return $this->view();
        }
    }
}