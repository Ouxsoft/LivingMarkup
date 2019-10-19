<?php

namespace Elements;

class Footer extends \Pxp\Element
{
	public function view() {
        return <<<HTML
<footer>
    <hr/>
    <p>&copy; <var name="year"/> <var name="username"/></p>
</footer>
<script/>
HTML;

	}
}