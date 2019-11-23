<?php
/*

Pxp\Hook

Define initial list of methods calls made sequentially to dyanmic element objects.
To orchestrate the method execution addition hooks may be defined within Tag Handlers. 

For a complete at runtime list, use $this->page->taglistHooks();

*/

namespace Pxp;

interface HookDefaultInterface
{
    
}

final class Hook implements HookDefaultInterface
{
    const VERSION = 0.1;

    public $description;
    public $name;
    public $position;
    public $is_render_call = FALSE;

    function __construct($name, $description, $position){

        // require name 
        if( isset($name) ){
            $this->name = $name;
        } else {
            trigger_error('Name missing from Hook supplied', E_USER_WARNING);
            return;
        }
        
        $this->description = isset($description) ?? $description;

        $this->position = isset($position) ?? $position;

    }
}