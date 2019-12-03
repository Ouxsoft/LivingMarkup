<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <contact@mrheroux.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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