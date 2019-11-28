<?php

namespace Pxp\DynamicElement;

class Footer extends DynamicElement
{
	public function onRender() {
        return <<<HTML
<footer>
    <hr/>
    <p>&copy; <var name="year"/> <var name="username"/></p>
</footer>
<script/>
HTML;

	}
}