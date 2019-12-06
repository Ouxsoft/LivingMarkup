<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This is a "Hello, World" example
 */

require '../../vendor/autoload.php';

/**
 * Class HelloWorld
 *
 * A simple HelloWorld DynamicElement example
 *
 * <widget name="HelloWorld"/>
 *
 * @package Pxp\DynamicElement\Widgets
 */
class HelloWorld extends \Pxp\DynamicElement\DynamicElement
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

// instantiate PageDirector
$director = new Pxp\Page\PageDirector();

// instantiate PageBuilder
$page_builder = new Pxp\Page\Builder\DynamicBuilder();

// define build parameters
$parameters = [
    'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'page.html',
    'handlers' => [
        '//widget'         => '{name}',
    ],
    'hooks' => [
        'onRender'      => 'RETURN_CALL',
    ]
];

// echo PageDirector build PageBuilder
echo $director->build($page_builder, $parameters);
