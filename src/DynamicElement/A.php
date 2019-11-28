<?php
namespace\Pxp\DynamicElement;

class A extends DynamicElement
{

    public function onRender()
    {
        // TODO: look up href id to allows for pages to be moved without updating link
        // id=""
        $this->href = isset($this->args['href']) ? $this->args['href'] : '#';
        $attribute_href = ' href="' . $this->href . '"';
        
        $this->alt = isset($this->args['alt']) ? $this->args['alt'] : 'decorative';
        $attribute_alt = ' alt="' . $this->alt . '"';
        
        return <<<HTML
        <a {$attribute_href}{$attribute_alt}>{$this->element}</a>
HTML;
    }
}
