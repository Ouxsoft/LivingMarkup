<?php

namespace Pxp;

/*
// separate the PXP document from it's processing

$pxp_doc = new PxP\Document($file);

$pxp_processor = new PXP\Processor();
    // hooks
    // elements
    // handlers
    // processor directory
    // maybe can allow hook to be inside module.
    // variables
    
    modules > 
    class A extends Elements {
        const XPATH / HANDLER = '//a';
        const HOOKS = ['afterFormSubmit'];
        const REQUIRED = ['Processor',]
    }

$pxp_processor->process($pxp_doc);

// like how mustash was done
*/

class Processor 
{
    // SPLObjectStorage
    private $handlers = NULL;
    private $hooks = NULL;

    public function __construct(){

        // object containing handlers
        $this->handlers = new \SplObjectStorage();

        // object containing hooks
        $this->hooks = new \SplObjectStorage();

        // objects containing elements
        $this->elements = new \SplObjectStorage();

    }

    // preprocess document
    public function process(&$pxp_doc) : bool {

        // create iterator to go through document looking for elements
        $this->xpath = new \DOMXPath($pxp_doc);

        // iterate through handlers
        foreach($this->handlers as $handler){
            
            // iterate through handler's expression searching for applicable elements
            foreach ($this->xpath->query($handler->xpath_expression) as $element) {

                // process element to get its new xml content
                $handler->process($pxp_doc, $element);
            }
        }

        return true;
    }

    // add multiple tag/element handlers at once
    public function handlersAdd(array $handlers) : bool {

        $success = true;

        foreach($handlers as $xpath_expression => $class_name){
            $result = $this->handlerAdd($xpath_expression, $class_name);
            
            if(! $result){
                $success = false;
            }
        }

        return $success;
    }

    // add a tag/element handler to list/array
    // a tag will only be process if handler is added for tag
    // tags without handlers will be left as is
    public function handlerAdd(string $xpath_expression, string $class_name) : bool {
        
        $handler = new Handler($xpath_expression, $class_name);
                
        $this->handlers->attach($handler);
        
        return true;
    }


    // add multiple hooks
    public function hooksAdd(array $hooks){
        foreach($hooks as $key => $value){
            // determine whether key value was passed or array
            if( is_array($value) ){
                $hook = $value;
            } else {
                $hook['name'] = $key;
                $hook['description'] = $value;
            }

            // require name 
            if( isset($hook['name']) ){
                $name = $hook['name'];
            } else {
                trigger_error('Name missing from Tag Hook supplied', E_USER_WARNING);
                return;
            }

            $description = isset($hook['description']) ?? $hook['description'];
            $position = isset($hook['position']) ?? $hook['position'];

            $this->hookAdd($name, $description, $position);
        }
    }

    // add a hook and pass to register
    public function hookAdd(string $name, string $description, string $position = NULL){
        $hook = new Hook();
        $hook->name = $name;
        $hook->description = $description;
        $hook->position = $position;
        $this->hookRegister($hook);
    }

    // return a list of hooks
    public function hooksList(){
        return $this->hooks;
    }

    // register the hook
    public function hookRegister(Hook $hook){    
        $this->hooks->attach($hook);
    }    

}