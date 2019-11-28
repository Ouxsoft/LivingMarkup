<?php
namespace Pxp\DynamicElement;

interface ElementDefaultInterface
{

    public function __construct($xml, $args);

    public function onRender();

    public function __toString();
}

abstract class DynamicElement implements ElementDefaultInterface
{

    // placeholder id for PageBuilder::replaceElement()
    public $placeholder_id = 0;
    // id used to load args
    public $id = 0;
    // name of element
    public $name = 'unknown';
    // inner content on load
    public $xml;
    // args passed to during construction
    public $args = [];
    // tags used for filtering
    public $tags = [];
    // render in search result builder
    public $search_index = true;
    // maximum results of data pulled
    public $max_results = '240';
    
    // extending class must define this method
    abstract public function onRender();

    // store parameters
    public function __construct($xml, $args)
    {
        // store elements inner xml
        $this->xml = $xml;
        // store args passed
        $this->args = $args;
        // assign object id to xml
        $this->placeholder_id = spl_object_hash($this);
    }

    // call to output method
    public function __toString()
    {
        if (method_exists($this, 'onRender')) {
            return $this->onRender();
        }
    }
}