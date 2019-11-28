<?php

namespace Pxp\DynamicElement;

class Redacted extends DynamicElement {
    public $char = '&#9608;';

    // ((profile_name == 222) and (profile_name !== 3))
    public function onRender(){
        $out = strip_tags($this->xml, '<p><div>');
        $count = strlen($out);
        $out = str_repeat($this->char, $count);
        return $out;
	}
}
