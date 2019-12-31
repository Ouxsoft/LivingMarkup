<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pxp\DynamicElement\Widgets;

use Pxp\DynamicElement\DynamicElement;

/**
 * Class HelloWorld
 *
 * A simple HelloWorld DynamicElement example
 *
 * <widget name="HelloWorld"/>
 *
 * @package Pxp\DynamicElement\Widgets
 */
class HelloWorld extends DynamicElement
{
    /**
     * Prints Hello, World
     *
     * @return mixed|string
     */
    public function onRender()
    {
        return 'Hello, World';
    }
}
