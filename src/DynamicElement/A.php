<?php

namespace \Pxp\DynamicElement;

class A extends DynamicElement
{
	// allows for pages to be moved without updating link
	//	href="id"

	// look up what id has been assigned to <a id=""?

	public function onRender(){

		$this->href = $this->args['href'];

		// look up
		$this->href="/home.html";

		$alt = '';
		if( isset($this->args['alt']) ){
			$alt = ' alt="' . $this->args['alt']. '"';
		}

		return <<<HTML
<a href="{$this->href}" {$alt}>{$this->element}</a>
HTML;

	}
}
