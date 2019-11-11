<?php
/*

Pxp\Director

Processing Documents

*/

namespace Pxp;


class Director
{
    // SPLObjectStorage
    private $handlers = NULL;
    private $hooks = NULL;
    private $elements = NULL;

    private $element_attribute_index = "_pxp_ref"; // used as a replacement point

    public function __construct(){

        $this->handlers = new \SplObjectStorage(); // object containing handlers
        $this->hooks = new \SplObjectStorage(); // object containing hooks
        $this->elements = new \SplObjectStorage(); // objects containing elements
    }

    // preprocess document
    public function process(Document &$pxp_doc, Template &$pxp_template = NULL) : bool {

        // create iterator to go through document looking for elements
        $this->xpath = new \DOMXPath($pxp_doc);

        // apply decorator/template
        if($pxp_template != NULL){
            $pxp_doc = $this->decoratorAdd($pxp_doc, $pxp_template);
        }

        // iterate through handlers
        foreach($this->handlers as $handler){
            
            // iterate through handler's expression searching for applicable elements
            foreach ($this->xpath->query($handler->xpath_expression) as $element) {

                // instantiate object of element
                $pxp_element = $handler->build($element);

                // if not found then replace with notice
                if( ! is_object($pxp_element) ){
                    $new_xml = '<!-- Handler "' . $this->tmp_class_name . '" Not Found -->';
                    $this->replace($pxp_doc, $element, $new_xml);
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

        // interate through hooks
        foreach($this->hooks as $hook){
    
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
    private function replace(Document &$pxp_doc, \DOMElement &$element, string $new_xml){

        // create a blank document fragment
        $fragment = $pxp_doc->createDocumentFragment();
        $fragment->appendXML($new_xml);

        // replace parent nodes child element with new fragement
        $element->parentNode->replaceChild($fragment, $element);
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

    // add decorator
    public function decoratorAdd(Document &$pxp_doc, Template &$template){
        // the decorator goes around the document
        // TODO:
        // recursively iterate through template appending doc
        // childern
        return $pxp_doc;
    }
}