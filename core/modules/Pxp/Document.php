<?php
/* 

Pxp\Document

PHP XML Preprocessor Document class  extends Document Object Model (DOM) Document class to provide class handler for specified XML elements.

*/
 
namespace Pxp;

interface DocumentDefaultInterface 
{
    public function load(string $filename, int $options = 0);
    public function preprocess() : bool;
//    public function elementProcess(object $handler, object $element) : bool;
    public function tagHandlersAdd(array $element_handlers) : bool;
    public function tagHandlerAdd(string $element, string $handler) : bool;
    public function argsGetFromElement(object $element) : array;
    public function __toString() : string;
}


class Document extends \DomDocument implements DocumentDefaultInterface 
{ 

    const VERSION = '1.0';

    private $pxp_processed = false;
    private $libxml_debug = false;

    // DomDocument settings
    public $preserveWhiteSpace = false;
    public $formatOutput = true;
    public $strictErrorChecking = FALSE;
    public $validateOnParse = FALSE;
    public $encoding = 'UTF-8';

    // SPLObjectStorage
    private $handlers = NULL;
    private $hooks = NULL;

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

    public function __construct(){
        // surpress xml parse errors unless debugging
        if( ! $this->libxml_debug){
            libxml_use_internal_errors(true);
        }

        // object containing handlers
        $this->tag_handlers = new \SplObjectStorage();

    }

    // custom load page wrapper for server side HTML5 entity support
    public function loadByPath(string $path) : void {

        // deliberately build out doc-type and grab file contents 
        // using alternative loadHTMLFile removes entities (&copy; etc.) 
        $source = '<!DOCTYPE html [';

        // entities are automatically removed before sending to client
        foreach($this->entities as $key => $value){
            $source .= '<!ENTITY ' . $key . ' "' . $value . '">' . PHP_EOL;
        }
        $source .= ']> ';
                
        $source .= file_get_contents($path);
        $this->loadXML($source);
    }


    // get element's innerXML
    function innerXML(\DOMElement $element){
        $xml = '';
        $children = $element->childNodes;
        foreach($children as $child){
            $xml .= $element->ownerDocument->saveHTML($child);
        }
        return $xml;
    }

    // replace element contents
    public function elementReplace(\DOMElement &$element, string $new_xml){

        // create a blank document fragment
        $fragment = $this->createDocumentFragment();

        // append new XML to fragment
        $fragment->appendXML($new_xml);

        // replace parent nodes child element with new fragement
        $element->parentNode->replaceChild($fragment, $element);
    }    

    // preprocess document
    public function preprocess() : bool {

        // create iterator to go through document looking for elements
        $this->xpath = new \DOMXPath($this);

        // iterate through handlers
        foreach($this->tag_handlers as $handler){
            
            // iterate through handler's expression searching for applicable elements
            foreach ($this->xpath->query($handler->xpath_expression) as $element_found) {

                // process element to get its new xml content
                $new_xml = $handler->elementProcess($element_found);

                // replace old element value with new xml content
                $this->elementReplace($element_found, $new_xml);
            }
        }

        // indicate that the document was processed
        $this->pxp_processed = true;

        return true;
    }

    // add multiple tag/element handlers at once
    public function tagHandlersAdd(array $tag_handlers) : bool {

        $success = true;

        foreach($tag_handlers as $xpath_expression => $class_name){
            $result = $this->tagHandlerAdd($xpath_expression, $class_name);
            
            if(! $result){
                $success = false;
            }
        }

        return $success;
    }

    // add a tag/element handler to list/array
    // a tag will only be process if handler is added for tag
    // tags without handlers will be left as is
    public function tagHandlerAdd(string $xpath_expression, string $class_name) : bool {
        
        $tag_handler = new Handler($this, $xpath_expression, $class_name);
                
        $this->tag_handlers->attach($tag_handler);
        
        return true;
    }

    // convert xml elements to array
    public function argsGetFromElement(object $element) : array {

        // get element @attributes and child elements
        $xml = $this->saveXML($element, LIBXML_NOEMPTYTAG);
        
        // TODO: find a better way than xml > string > xml > json > array
        $root = simplexml_load_string($xml);

        // only get arguments 2 deep
        $json = json_encode($root, 0, 2);
        $args = json_decode($json, true);
 
        return $args;
    }

    // returns the pxp_processed document as string
    public function __toString() : string {

        // process if not yet done
        if( ! $this->pxp_processed){
            $this->preprocess();
        }
        
        return $this->saveHTML();
    }
}