<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use LivingMarkup\Component\Component;

require '../../vendor/autoload.php';

function call_director($buffer)
{
    // instantiate Director
    $director = new LivingMarkup\Director();

    // instantiate Builder
    $builder = new LivingMarkup\Builder\DynamicPageBuilder();

    // define build parameters
    $parameters = [
        'markup' => $buffer,
        'handlers' => [
            '//widget' => 'LivingMarkup\Component\Widgets\{name}',
            '//img' => 'LivingMarkup\Component\Img',
            '//a' => 'LivingMarkup\Component\A',
            '//var' => 'LivingMarkup\Component\Variable',
            '//condition' => 'LivingMarkup\Component\Condition',
            '//redacted' => 'LivingMarkup\Component\Redacted'
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