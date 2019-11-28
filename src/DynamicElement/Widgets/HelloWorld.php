<?php
namespace Pxp\DynamicElement\Widgets;

class HelloWorld extends \Pxp\DynamicElement\DynamicElement
{
	public function onRender(){
		return 'Hello World';
	}
}