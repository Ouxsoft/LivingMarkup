<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pxp\Component\Widgets;

use Pxp\Component\Component;

/**
 * Class HelloWorld
 *
 * A simple HelloWorld Component example
 *
 * <widget name="HelloWorld"/>
 *
 * @package Pxp\Component\Widgets
 */
class HelloWorld extends Component
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
