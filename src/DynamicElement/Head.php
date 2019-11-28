<?php

namespace Pxp\DynamicElement;

class Head extends DynamicElement
{
	public function onRender() {
		return <<<HTML
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
	<title>My Website</title>
	<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
HTML;

	}
}