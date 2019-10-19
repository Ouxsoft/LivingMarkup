<?php

namespace Partials;

class UserMenu extends \Pxp\Element
{
	public function view(){
        return <<<HTML
           
<div>
        <!-- User Menu -->
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