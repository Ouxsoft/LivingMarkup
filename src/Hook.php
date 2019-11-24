<?php

namespace Pxp;

interface HookDefaultInterface
{
    function __construct($name, $description, $position);
}

final class Hook implements HookDefaultInterface
{
    const VERSION = 0.1;

    public $description;
    public $name;
    public $position;
    public $is_render_call = FALSE;

    function __construct($name, $description, $position) {

        // require name 
        if( isset($name) ){
            $this->name = $name;
        } else {
            trigger_error('Name missing from Hook supplied', E_USER_WARNING);
            return false;
        }
        
        $this->description = isset($description) ?? $description;

        $this->position = isset($position) ?? $position;
        
        return true;
        
    }
}