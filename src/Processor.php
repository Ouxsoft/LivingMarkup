<?php

namespace Pxp;


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

                // instantiate object of element
                $pxp_element = $handler->build($element);

                // if not found then replace with notice
                if( ! is_object($pxp_element) ){
                    $new_xml = $this->error('Not Found');
                    $this->replace($pxp_doc, $element, $new_xml);
                    continue;
                } 

                // assign object id to xml
                $element_id = spl_object_hash($pxp_element);
                $pxp_element->pxp_id = $element_id;
                $element->setAttribute('pxp_id', $element_id);
                
                // store object
                $this->elements->attach($pxp_element);          
            }
        }

        // interate through hooks
        foreach($this->hooks as $hook){
    
            // iterate through elements
            foreach($this->elements as $element){
    
                // skip if element does not feature hook
                if ( ! method_exists($element, $hook->name) ) {
                    continue;
                }
                
                // if view
                if($hook->name == 'view'){
                    
                    $new_xml = $element->view();
                    
                    $query = '//*[@pxp_id="' . $element->pxp_id . '"]';
                    foreach ($this->xpath->query($query) as $replace_element) {
                        $this->replace($pxp_doc, $replace_element, $new_xml);

                    }
                } else {

                    // call element method
                    call_user_func([$element, $hook->name]);
                }
            }
        }       

        return true;
    }

    // replace element contents
    private function replace(&$pxp_doc, \DOMElement &$element, string $new_xml){

        // create a blank document fragment
        $fragment = $pxp_doc->createDocumentFragment();
        $fragment->appendXML($new_xml);

        // replace parent nodes child element with new fragement
        $element->parentNode->replaceChild($fragment, $element);
    }    

    // comment for errors
    private function error($type){
        return '<!-- Handler "' . $this->tmp_class_name . '" ' . $type . ' -->';
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
