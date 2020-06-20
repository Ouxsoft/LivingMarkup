<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Test;

use LivingMarkup\Element;

/**
 * Class HelloWorld
 *
 * Hyperlink simple HelloWorld Element example
 *
 * <widget name="HelloWorld"/>
 *
 * @package LivingMarkup\Elements\Widgets
 */
class HelloWorld extends Element
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
