<?php

namespace Pxp\DynamicElement\Widgets;
use Pxp\DynamicElement\DynamicElement as DynamicElement;

class UserMenu extends DynamicElement
{
	public function onRender(){
        return <<<HTML
<!-- User Menu -->
<div>
<condition toggle="signed_in">
    <h2>Welcome, <var name="username"/></h2>
    <p>You're signed in right now</p>
</condition>
<condition toggle="signed_out">
    <a href="1000" alt="Test">Sign in</a>
</condition>
</div>
HTML;
    }
}