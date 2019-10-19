<?php

namespace Elements;

class A extends \Pxp\Element
{
	// allows for pages to be moved without updating link
	//	href="id"

	public $href = '/';

// look up what id has been assigned to <a id=""?

	public function view(){

		$this->href = $this->args['@attributes']['href'];

		$this->href="/home.html";

		if(isset($this->args['@attributes']['alt'])){
			$alt = ' alt="' . $this->args['@attributes']['alt']. '"';
		}

		return <<<HTML
<a href="{$this->href}" {$alt}>{$this->element}</a>
HTML;

	}
}
