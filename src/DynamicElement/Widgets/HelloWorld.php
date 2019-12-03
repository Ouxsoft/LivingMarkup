<?php
namespace Pxp\DynamicElement\Widgets;

/**
 * Class HelloWorld
 *
 * A simple HelloWorld DynamicElement example
 *
 * <widget name="HelloWorld">
 * </widget>
 *
 * @package Pxp\DynamicElement\Widgets
 */
class HelloWorld extends \Pxp\DynamicElement\DynamicElement
{
    /**
     * Prints HelloWorld
     *
     * @return mixed|string
     */
    public function onRender(){
		return 'Hello World';
	}
}