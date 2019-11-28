<?php
namespace Pxp\DynamicElement\Widgets;
use Pxp\DynamicElement\DynamicElement as DynamicElement;

class HelloWorld extends DynamicElement
{
	public function onRender(){
		return 'Hello World';
	}
}
