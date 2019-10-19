<?php

/*

Tag Hook

Define initial list of methods calls made sequentially to dyanmic element objects.
To orchestrate the method execution addition hooks may be defined within Tag Handlers. 

For a complete at runtime list, use $pxp_doc->tagHooksList();

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
}