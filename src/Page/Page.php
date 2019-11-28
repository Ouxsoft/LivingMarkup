<?php
 
namespace Pxp\Page;

interface PageDefaultInterface 
{
    public function loadByPath(string $filepath) : void;
    public function __toString() : string;
    public function callHook(string $hook_name, string $options = NULL) : bool;
    public function instantiateElement(string $xpath_expression, string $class_name) : bool;
    public function replaceElement(\DOMElement &$element, string $new_xml) : void;
    public function query($query);
}

class Page implements PageDefaultInterface 
{ 

    public $dom;
    public $xpath;
    public $element_objects;
    public $arg_load_function;
    
    private $element_index_attribute = '_pxp_ref';
  
    private $libxml_debug = false;
      
    // DomDocument settings
    public $preserveWhiteSpace = false;
    public $formatOutput = true;
    public $strictErrorChecking = FALSE;
    public $validateOnParse = FALSE;
    public $encoding = 'UTF-8';

    public $includes = [
        'js' => [],
        'css' => []
    ];

    // entites are required to avoid server side DOM parse errors
    public $entities = [
        'nbsp' => '&#160;',
        'copy' => '&#169;',
        'reg' => '&#174;',
        'trade' => '&#8482;',
        'mdash' => '&#8212;'
    ];    

    public function __construct($filename = NULL)
    {
    
        // create a document object model
        $this->dom = new \DomDocument();
     
        // objects containing elements
        $this->element_objects = new \SplObjectStorage();
        
        // surpress xml parse errors unless debugging
        if( ! $this->libxml_debug){
            libxml_use_internal_errors(true);
        }
        
        if($filename != NULL){
            $this->loadByPath($filename);
        }
    }

    // calls method from each instaniated element
    public function callHook(string $hook_name, string $options = NULL) : bool
    {
        
        // iterate through elements
        foreach($this->element_objects as $element) {
            
            // skip if element does not feature hook
            if ( ! method_exists($element, $hook_name) ) {
                continue;
            }
            
            // on render
            if($options == 'RETURN_CALL') {
                
                $new_xml = $element->onRender();
                
                $query = '//*[@' . $this->element_index_attribute . '="' . $element->placeholder_id . '"]';
                
                foreach ($this->query($query) as $replace_element) {
                    
                    $this->replaceElement($replace_element, $new_xml);
                    
                }
                
            } else {
                
                // call element method
                call_user_func([$element, $hook_name]);
                
            }
        }
        
        return true;        
    }
    
    // instantiates dynamic elements found during xpath query
    public function instantiateElement(string $xpath_expression, string $class_name) : bool
    {
        // if class does not exist replace element with informative comment
        // iterate through handler's expression searching for applicable elements
        foreach ($this->query($xpath_expression) as $element) {
    
            // resolve class name 
            if( $element->hasAttribute('name') ) {
                $element_name = $element->getAttribute('name');
                $class_name = str_replace('{name}', $element_name, $class_name);
            }
            
            // if class does not exist
            if( ! class_exists($class_name) ){
                $this->replaceElement($element, '<!-- Handler "' . $class_name . '" Not Found -->');
                return false;
            }
            
            // get xml from element
            $xml = $this->getXml($element);
            
            // get args from element
            $args = $this->getArgs($element);
            
            // instantiate element
            $element_object = new $class_name($xml, $args);
                        
            // object not instantiated
            if( ! is_object($element_object) ){
                $this->replaceElement($element, '<!-- Handler "' . $class_name . '" Error -->');
                continue;
            }
            
            // set element object placeholder
            $element->setAttribute($this->element_index_attribute, $element_object->placeholder_id);
            
            // store object
            $this->element_objects->attach($element_object);
        }
        
        return true;
    }
    
    // get element's innerXML
    private function getXml(\DOMElement $element) : string
    {
        
        $xml = '';
        
        $children = $element->childNodes;
        foreach($children as $child){
            $xml .= $element->ownerDocument->saveHTML($child);
        }
        
        return $xml;
    }
    
    // get element args
    private function getArgs(\DOMElement &$element) : array
    {
        
        $args = [];
        
        // get attributes
        if( $element->hasAttributes() ){
            foreach($element->attributes as $name => $attribute){
                $args[$name] = $attribute->value;
            }
        }
        
        // get child args
        $objects = $element->getElementsByTagName('arg');
        foreach($objects as $object) {
            $name = $object->getAttribute('name');
            $value = $object->nodeValue;
            $args[$name] = $value;
        }
        
        // use element id attribute to load args
        if( $element->hasAttribute('id') ) {
            $element_id = $element->getAttribute('id');
            
            // allow director to specify function to load args from based on id
            if(function_exists($this->arg_load_function)){
                $args_loaded = call_user_func($this->arg_load_function, $element_id);
                
                // merge args
                $args = array_merge($args_loaded, $args);
            }
            
        }
        
        return $args;
    }
    
    // replace element contents
    public function replaceElement(\DOMElement &$element, string $new_xml) : void
    {

        // create a blank document fragment
        $fragment = $this->dom->createDocumentFragment();
        $fragment->appendXML($new_xml);

        // replace parent nodes child element with new fragement
        $element->parentNode->replaceChild($fragment, $element);
       
    }

    // custom load page wrapper for server side HTML5 entity support
    public function loadByPath(string $filepath) : void 
    {

        // entities are automatically removed before sending to client
        $entity = '';
        foreach($this->entities as $key => $value){
            $entity .= '<!ENTITY ' . $key . ' "' . $value . '">' . PHP_EOL;
        }

        // deliberately build out doc-type and grab file contents 
        // using alternative loadHTMLFile removes entities (&copy; etc.) 
        $source = '<!DOCTYPE html [' . $entity . ']> ';
        $source .= file_get_contents($filepath);
        $this->dom->loadXML($source);
        
        // create document iterator
        $this->xpath = new \DOMXPath($this->dom);
        
    }

    // returns dom as html
    public function __toString() : string 
    {
        
        return $this->dom->saveHTML();
    }
    
    // xpath query for dom
    public function query($query){
        return $this->xpath->query($query);
    }
}