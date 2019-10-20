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

    public $completed = true;

    public function __construct(){
        // object containing hooks
        $this->tag_handler_hooks = new \SplObjectStorage();
    }

    public function http_header(){

        // header('HTTP/1.1 500 OK');
        http_response_code(200);   
    }

    // output header
//    $this->http_header();


    // add multiple hooks
    public function tagHooksAdd(array $hooks){
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

            $this->tagHookAdd($name, $description, $position);
        }
    }

    // add a hook and pass to register
    public function tagHookAdd(string $name, string $description, string $position = NULL){
        $hook = new Hook();
        $hook->name = $name;
        $hook->description = $description;
        $hook->position = $position;
        $this->tagHookRegister($hook);
    }

    // return a list of hooks
    public function tagHooksList(){
        return $this->tag_handler_hooks;
    }

    // register the hook
    public function tagHookRegister(Hook $hook){    
        $this->tag_handler_hooks->attach($hook);
    }    

}