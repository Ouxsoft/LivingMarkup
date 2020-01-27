<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Pxp\Component\Component;

require '../../vendor/autoload.php';

function call_director($buffer)
{
    // instantiate Director
    $director = new Pxp\Director();

    // instantiate Builder
    $builder = new Pxp\Builder\DynamicPageBuilder();

    // define build parameters
    $parameters = [
        'markup' => $buffer,
        'handlers' => [
            '//widget' => 'Pxp\Component\Widgets\{name}',
            '//img' => 'Pxp\Component\Img',
            '//a' => 'Pxp\Component\A',
            '//var' => 'Pxp\Component\Variable',
            '//condition' => 'Pxp\Component\Condition',
            '//redacted' => 'Pxp\Component\Redacted'
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

    // echo Director build of Builder
    return $director->build($builder, $parameters);

}

ob_start('call_director');