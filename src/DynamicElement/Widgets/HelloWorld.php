<?php
/*
 * <widget name="HelloWorld">
 * </widget>
 */
namespace Pxp\DynamicElement\Widgets;

class HelloWorld extends \Pxp\DynamicElement\DynamicElement
{
	public function onRender(){
		return 'Hello World';
	}
}