<?php

namespace Pxp\Page\Builder;

class StaticTemplateBuilder extends Builder
{
    private $page;
    
    public function createObject($parameters) : ?bool
    {
        if( !isset($parameters['filename'])){
            return false;
        }

        // only allow files inside template directory to be loaded
        if ( !isTemplateFile($parameter['filename'], $parameters['template_dir']) ){
            return false;
        }
        
        $this->page = new Pxp\Page\Page($parameters['filename']);        
        
        return true;
    }
    
    public function getObject() : ?object
    {
        return $this->page;
    }
    
    public function isTemplateFile($path = NULL, $template_dir = NULL) : bool {
        
        $directory = dirname($path);
        $directory = realpath($directory);        
        $folder = substr($path, strlen($directory) );
        $folder = preg_replace('/[^a-z0-9\.\-_]/i', '', $folder);
        
        if( ( !$directory ) || ( !$folder ) || ( $folder === '.') ) {
            return FALSE;
        }
        
        $path = $directory . DIRECTORY_SEPARATOR . $folder;
        if( strcasecmp($path, $template_dir) > 0 ) {
            return TRUE;
        }
        
        return FALSE;
    }
}