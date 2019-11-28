<?php
namespace Pxp\DynamicElement;

class Redacted extends DynamicElement
{

    public $char = '&#9608;';

    public function onRender(): string
    {
        $out = strip_tags($this->xml, '<p><div>');
        $count = strlen($out);
        $out = str_repeat($this->char, $count);
        return $out;
    }
}