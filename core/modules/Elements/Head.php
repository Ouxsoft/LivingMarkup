<?php

namespace Elements;

class Head extends \Pxp\Element
{
	public function view() {
		return <<<HTML
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
	<title>My Website</title>
	<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
HTML;

	}
}