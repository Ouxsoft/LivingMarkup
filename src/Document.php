<?php
/* 

Pxp\Document

PXP Document class extends Document Object Model (DOM) Document class.
It features addition properties and methods to work with PXP.
*/
 
namespace Pxp;

interface DocumentDefaultInterface 
{
    public function load(string $filename, int $options = 0);
    public function loadByPath(string $path) : void;
    public function __toString() : string;
}

class Document extends \DomDocument implements DocumentDefaultInterface 
{ 
    const VERSION = '1.0';

    private $libxml_debug = false;

    // DomDocument settings
    public $preserveWhiteSpace = false;
    public $formatOutput = true;
    public $strictErrorChecking = FALSE;
    public $validateOnParse = FALSE;
    public $encoding = 'UTF-8';

    public $xpath;

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

    }

    // replace element contents
    public function replaceElement(\DOMElement &$element, string $new_xml){

        // create a blank document fragment
        $fragment = $this->createDocumentFragment();
        $fragment->appendXML($new_xml);

        // replace parent nodes child element with new fragement
        $element->parentNode->replaceChild($fragment, $element);
    }

    // custom load page wrapper for server side HTML5 entity support
    public function loadByPath(string $path) : void {

        // entities are automatically removed before sending to client
        $entity = '';
        foreach($this->entities as $key => $value){
            $entity .= '<!ENTITY ' . $key . ' "' . $value . '">' . PHP_EOL;
        }

        // deliberately build out doc-type and grab file contents 
        // using alternative loadHTMLFile removes entities (&copy; etc.) 
        $source = '<!DOCTYPE html [' . $entity . ']> ';
        $source .= file_get_contents($path);
        $this->loadXML($source);
    }

    // returns the pxp_processed document as string
    public function __toString() : string {

        return $this->saveHTML();
    }
}