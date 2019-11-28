<?php
namespace Pxp\DynamicElement;

class Footer extends DynamicElement
{

    public function getPageScripts(){
        // TODO: figure out how this works
    }
    
    public function onRender()
    {
        return <<<HTML
<footer>
    <hr/>
    <p>&copy; <var name="year"/> <var name="username"/></p>
</footer>
<script/>
HTML;
    }
}