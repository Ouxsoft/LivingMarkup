<?php
 
namespace Pxp;

interface PageDefaultInterface 
{
    public function loadByPath(string $filepath) : void;
    public function __toString() : string;
}

class Page implements PageDefaultInterface 
{ 

    public $dom;
    public $xpath;
    public $element_objects;
    
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

    public function __construct()
    {
    
        // create a document object model
        $this->dom = new \DomDocument();
     
        // objects containing elements
        $this->element_objects = new \SplObjectStorage();
        
        // surpress xml parse errors unless debugging
        if( ! $this->libxml_debug){
            libxml_use_internal_errors(true);
        }

    }

    // calls method from each instaniated element
    public function callHook(string $hook_name, string $description = '', $options = NULL) : bool
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
        
        $element_builder = new ElementBuilder();
                
        // iterate through handler's expression searching for applicable elements
        foreach ($this->query($xpath_expression) as $element) {
            
            $element_builder->setElement($element);
            $element_builder->setClassName($class_name);
            $element_builder->createObject();
            
            $element_object = $element_builder->getObject();
            
            // if class does not exist replace element with informative comment
            if( ! is_object($element_object) ){
                $this->replaceElement($element, '<!-- Handler "' . $this->tmp_class_name . '" Not Found -->');
                continue;
            }
            
            // store object placeholder
            $element->setAttribute($this->element_index_attribute, $element_object->placeholder_id);
            
            // store object
            $this->element_objects->attach($element_object);
        }
        
        return true;
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