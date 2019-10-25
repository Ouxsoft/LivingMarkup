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

    public $include_in_search_index = true;
    public $name = 'unknown';
    public $element;
    public $id = 0;
    public $attributes = [];
    public $args = [];
    public $tags = [];

    // extending class must define this method
    abstract public function view();

    public function display(){
        $this->element = $this->view();
    }

    // get any argments set in element passed by Pxp\Document
    public function __construct(&$pxp_doc_object, $element, $args){
        $this->pxp_doc_object = $pxp_doc_object;
        $this->element = $element;
        $this->args = $args; //func_get_args();
    }

    public function __toString(){
        // view
        if( method_exists($this,'view') ){
            return $this->view();
        }
    }
}


