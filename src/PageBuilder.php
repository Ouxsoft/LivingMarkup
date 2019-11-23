<?php

namespace Pxp;

class PageBuilder extends Builder
{
    public $path;
    private $page;
    
    // SPLObjectStorage
    private $handlers = NULL;
    private $hooks = NULL;
    private $elements = NULL;
    
    // used as a replacement point
    private $element_attribute_index = "_pxp_ref";
    
    public function __construct()
    {
         // object containing handlers
         $this->handlers = new \SplObjectStorage();
         
         // object containing hooks
         $this->hooks = new \SplObjectStorage();
         
         // objects containing elements
         $this->elements = new \SplObjectStorage();
    }
    
    public function createPage()
    {       
        $this->page = new Page();
        $this->page->loadByPath($this->path);
     
        // create iterator to go through document looking for elements
        $this->xpath = new \DOMXPath($this->page);
        
        // iterate through handlers
        foreach($this->handlers as $handler){            
            $this->handlerBuilder($handler);
        }
        
        // interate through hooks
        foreach($this->hooks as $hook){
            $this->hooksBuilder($hook);
        }
    
    }
    
    public function getPage()
    {
        return $this->page;       
    }
    
    // add a tag/element handler to storage
    // only tags with handlers are built; elements without handlers are left alone
    public function addHandler(string $xpath_expression, string $class_name) : bool
    {
        
        $handler = new Handler($xpath_expression, $class_name);
        
        $this->handlers->attach($handler);
        
        return true;
    }
    
    // builds handlers
    private function handlerBuilder(Handler $handler)
    {
        
        // iterate through handler's expression searching for applicable elements
        foreach ($this->query($handler->xpath_expression) as $element) {
        
            // instantiate object of element
            $pxp_element = $handler->build($element);
            
            // if not found then replace with notice
            if( ! is_object($pxp_element) ){
                $new_xml = '<!-- Handler "' . $this->tmp_class_name . '" Not Found -->';
                $this->page->replaceElement($element, $new_xml);
                
                continue;
            }
            
            // assign object id to xml
            $element_id = spl_object_hash($pxp_element);
            $pxp_element->pxp_id = $element_id;
            $element->setAttribute($this->element_attribute_index, $element_id);
            
            // store object
            $this->elements->attach($pxp_element);
        }
    }
    
    // hooks builder
    private function hooksBuilder(Hook $hook)
    {
    
        // iterate through elements
        foreach($this->elements as $element){
        
            // skip if element does not feature hook
            if ( ! method_exists($element, $hook->name) ) {
                continue;
            }
            
            // on render
            if($hook->name == 'onRender'){
                
                $new_xml = $element->onRender();
                
                $query = '//*[@' . $this->element_attribute_index . '="' . $element->pxp_id . '"]';
                
                foreach ($this->query($query) as $replace_element) {
                
                    $this->page->replaceElement($replace_element, $new_xml);
                
                }
                
            } else {
            
                // call element method
                call_user_func([$element, $hook->name]);
                
            }
        }
    }
    
    // add a hook and pass to register
    public function addHook(string $name, string $description = '', $position = NULL){
        
        $hook = new Hook($name, $description, $position);
        $this->registerHook($hook);
    
    }
    
    // return a list of hooks
    public function listHooks(){
    
        return $this->hooks;
    
    }
    
    // register the hook
    public function registerHook(Hook $hook){
    
        $this->hooks->attach($hook);
    
    }
    
    // TODO: consider using generator
    public function query($query){
        
        return $this->xpath->query($query);
        
    }
    
}