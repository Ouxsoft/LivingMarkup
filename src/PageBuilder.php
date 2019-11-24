<?php

namespace Pxp;

class PageBuilder extends Builder
{
    private $page;
    private $path;
        
    public function createObject() : ?bool
    {       
        $this->page = new Page();
        $this->page->loadByPath($this->path);

        // instantiate dynamic elements
        $this->page->instantiateElement('//partial','Partials\{name}');
        $this->page->instantiateElement('//partial','Partials\{name}');
        $this->page->instantiateElement('//widget','Widgets\{name}');
        $this->page->instantiateElement('//head','Elements\Head');
        $this->page->instantiateElement('//img','Elements\Img');
        $this->page->instantiateElement('//a','Elements\A');
        $this->page->instantiateElement('//footer','Elements\Footer');
        $this->page->instantiateElement('//var','Logic\Variable');
        $this->page->instantiateElement('//condition','Logic\Condition');
        $this->page->instantiateElement('//redacted','Logic\Redacted');
               
        // call methods from each dyanamic element
        $this->page->callHook('beforeLoad', 'Executed before onLoad');
        $this->page->callHook('onLoad', 'Loads object data', 'LOAD_CALL');
        $this->page->callHook('afterLoad', 'Executed after onLoad');
        $this->page->callHook('beforeRender', 'Executed before onLoad');
        $this->page->callHook('onRender', 'Returns the object as string', 'RETURN_CALL');
        $this->page->callHook('afterRender', 'Executed after onRender');
              
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

}