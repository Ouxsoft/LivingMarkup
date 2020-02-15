<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Modules\Widgets;

use LivingMarkup\Modules\Module;

/**
 * Class HelloWorld
 *
 * Hyperlink simple HelloWorld Module example
 *
 * <widget name="HelloWorld"/>
 *
 * @package LivingMarkup\Modules\Widgets
 */
class HelloWorld extends \LivingMarkup\Module
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
