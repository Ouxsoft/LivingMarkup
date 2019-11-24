<?php

namespace Pxp;

class PageBuilder extends Builder
{
    public $path;
    private $page;
    
    // SPLObjectStorage
    private $hooks = NULL;
    private $elements = NULL;
    
    private $elements_metadata = [];
    
    // placeholder for replacement
    private $element_attribute_index = "_pxp_ref";
    
    public function __construct()
    {
                        
        // object containing hooks
        $this->hooks = new \SplObjectStorage();
        
        // objects containing elements
        $this->element_objects = new \SplObjectStorage();
        
    }
    
    public function createObject() : ?bool
    {       
        $this->page = new Page();
        $this->page->loadByPath($this->path);
     
        // create document iterator
        $this->xpath = new \DOMXPath($this->page);
        
        // build elements
        $this->elementsBuild();
        
        // build hooks
        $this->hooksBuild();
      
        return true;
    }
    
    public function getObject() : ?object
    {
        return $this->page;       
    }
    
    public function setPath($path)
    {
        $this->path = $path;
    }

    
    public function addElement(string $xpath_expression, string $class_name) : bool
    {

        $this->element_metadata[$xpath_expression] = $class_name;
        
        return true;
    }
    
    private function elementsBuild()
    {
            
        $element_builder = new ElementBuilder();
        
        foreach($this->element_metadata as $xpath_expression => $class_name){
                
            // iterate through handler's expression searching for applicable elements        
            foreach ($this->query($xpath_expression) as $element) {
            
                $element_builder->element_node = $element;
                $element_builder->class_name = $class_name;
                $element_builder->createObject();
                
                $element_object = $element_builder->getObject();
                
                // if not found then replace with notice
                if( ! is_object($element_object) ){
                    $this->page->replaceElement($element, '<!-- Handler "' . $this->tmp_class_name . '" Not Found -->');                    
                    continue;
                }
                
                // store object placeholder
                $element->setAttribute($this->element_attribute_index, $element_object->placeholder_id);
                
                // store object
                $this->element_objects->attach($element_object);
            }
        }
    }
            
    // hooks builder
    private function hooksBuild()
    {
        foreach($this->hooks as $hook) {
            
            // iterate through elements
            foreach($this->element_objects as $element) {
            
                // skip if element does not feature hook
                if ( ! method_exists($element, $hook->name) ) {
                    continue;
                }
                
                // on render
                if($hook->name == 'onRender') {
                    
                    $new_xml = $element->onRender();
                    
                    $query = '//*[@' . $this->element_attribute_index . '="' . $element->placeholder_id . '"]';
                    
                    foreach ($this->query($query) as $replace_element) {
                    
                        $this->page->replaceElement($replace_element, $new_xml);
                    
                    }
                    
                } else {
                
                    // call element method
                    call_user_func([$element, $hook->name]);
                    
                }
            }
        }
    }
    
    // add a hook and pass to register
    public function addHook(string $name, string $description = '', $position = NULL)
    {
        
        $hook = new Hook($name, $description, $position);
        $this->registerHook($hook);
    
    }
    
    // return a list of hooks
    public function listHooks()
    {
    
        return $this->hooks;
    
    }
    
    // register the hook
    public function registerHook(Hook $hook)
    {
    
        $this->hooks->attach($hook);
    
    }
    
    // TODO: consider using generator
    public function query($query)
    {
        
        return $this->xpath->query($query);
        
    }
    
}