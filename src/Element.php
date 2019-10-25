<?php 
/*

Pxp\Element

This is an abstract class inteded to be extended by Pxp element handlers

*/

namespace Pxp;

interface ElementDefaultInterface
{
    const MAX_RESULTS = '240';
    public function view();
    public function __toString();
}

abstract class Element implements ElementDefaultInterface
{

    public $search_index = true; 
    public $name = 'unknown'; // name of element
    public $xml; // inner content on load
    public $id = 0; // id used to load args
    public $args = []; // args passed to during constrcution
    public $tags = []; // tags

    // extending class must define this method
    abstract public function view();

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


