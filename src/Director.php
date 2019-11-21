<?php
/*

Pxp\Director

Directs Pxp Processing

*/

namespace Pxp;


class Director
{
    // SPLObjectStorage
    private $handlers = NULL;
    private $hooks = NULL;
    private $elements = NULL;

    // used as a replacement point
    private $element_attribute_index = "_pxp_ref"; 
    
    public function __construct() {

        // object containing handlers
        $this->handlers = new \SplObjectStorage();

        // object containing hooks
        $this->hooks = new \SplObjectStorage(); 

        // objects containing elements
        $this->elements = new \SplObjectStorage(); 
    
    }

    // builder document
    public function builder(Document &$pxp_doc) : bool {

        // create iterator to go through document looking for elements
        $this->xpath = new \DOMXPath($pxp_doc);

        /*

        // Handler Builder
        $this->handler_builder = new HandlerBuilder();
        $this->handler_builder->add($this->handlers);

        // Hook Builder
        $this->hook_builder = new HookBuilder();
        $this->hook_builder->add($this->hooks);
        $this->hook_builder->build();

        */
        // HandlerBuilder::build($pxp_doc, $this->handler);
        // HookBuilder::build($pxp_doc, $this->hooks);


        // iterate through handlers
        foreach($this->handlers as $handler){

            $this->handlerBuilder($pxp_doc, $handler);

        }

        // interate through hooks
        foreach($this->hooks as $hook){
        
            $this->hooksBuilder($pxp_doc, $hook);
        
        }

        return true;
    }

    // builds handlers
    private function handlerBuilder(Document &$pxp_doc, Handler $handler){
        
        // iterate through handler's expression searching for applicable elements
        foreach ($this->query($handler->xpath_expression) as $element) {

            // instantiate object of element
            $pxp_element = $handler->build($element);

            // if not found then replace with notice
            if( ! is_object($pxp_element) ){
                $new_xml = '<!-- Handler "' . $this->tmp_class_name . '" Not Found -->';
                $pxp_doc->replaceElement($element, $new_xml);

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

    // add a tag/element handler to storage
    // only tags with handlers are built; elements without handlers are left alone
    public function handlerAdd(string $xpath_expression, string $class_name) : bool {
        
        $handler = new Handler($xpath_expression, $class_name);
                
        $this->handlers->attach($handler);
        
        return true;
    }

    // hooks builder
    private function hooksBuilder(Document &$pxp_doc, Hook $hook){

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
                
                    $pxp_doc->replaceElement($replace_element, $new_xml);

                }

            } else {

                // call element method
                call_user_func([$element, $hook->name]);
            }
        }    
    }

    // TODO: consider using generator?
    public function query($query){

        return $this->xpath->query($query);

    }

    // add a hook and pass to register
    public function hookAdd(string $name, string $description = '', $position = NULL){

        $hook = new Hook($name, $description, $position);
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

    // apply decorator
    public function decoratorApply(Document &$pxp_doc, Template &$template){
        // the decorator goes around the document

        // find Document root elements

        // locate first node in the template 
        // that can be associated with the node
        // apply a object id
        // when finished replace all at once to avoid recusrsion
        // or other method, i.e. storing in list
        // with element that has all the attributes from the templat

        // template_placeholder="main nav"

    }
}
