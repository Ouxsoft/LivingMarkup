<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Pxp\DynamicElement\DynamicElement;

require '../../vendor/autoload.php';

function call_director($buffer)
{
    // instantiate PageDirector
    $director = new Pxp\Page\PageDirector();

    // instantiate PageBuilder
    $page_builder = new Pxp\Page\Builder\DynamicBuilder();

    // define build parameters
    $parameters = [
        'markup' => $buffer,
        'handlers' => [
            '//widget' => 'Pxp\DynamicElement\Widgets\{name}',
            '//img' => 'Pxp\DynamicElement\Img',
            '//a' => 'Pxp\DynamicElement\A',
            '//var' => 'Pxp\DynamicElement\Variable',
            '//condition' => 'Pxp\DynamicElement\Condition',
            '//redacted' => 'Pxp\DynamicElement\Redacted'
        ],
        'hooks' => [
            'beforeLoad' => 'Executed before onLoad',
            'onLoad' => 'Loads object data',
            'afterLoad' => 'Executed after onLoad',
            'beforeRender' => 'Executed before onLoad',
            'onRender' => 'RETURN_CALL',
            'afterRender' => 'Executed after onRender',
        ]
    ];

    // echo PageDirector build PageBuilder
    return $director->build($page_builder, $parameters);

}

ob_start('call_director');