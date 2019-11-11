<?php

/*

DomTemplate\

Pxp Document replacement


implentation ideas:
    xpath expressions
    If xpath exists in page replace childNodes with doc.

    Templates help to lighten the contents of an Pxp\Document.
    Templates allow for easier management.

How??

    // find root
    // if root is html start processing there.
    // if root is body start processing there
    
    foreach element
        xparse

        structure
*/

namespace Pxp;

interface TemplateDefaultInterface 
{    
//    public function apply($dom, $template);
//    public function load();
//    public function replace();
//    public function merge();
}


class Template extends Document implements TemplateDefaultInterface
{

}