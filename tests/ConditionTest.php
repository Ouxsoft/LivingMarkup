<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Pxp\Tests;

use PHPUnit\Framework\TestCase;

final class ConditionTest extends TestCase
{
    public function testConditions()
    {
        define('PXP_DATETIME', '2019-12-03 01:30:00');

        $parameters = [
            'filename' => __DIR__ . '/../examples/ConditionExample/input.html',
            'handlers' => [
                '//condition'   => 'Pxp\DynamicElement\Condition',
            ],
            'hooks' => [
                'onRender'      => 'RETURN_CALL',
            ]
        ];

        // build dynamic page
        $director = new \Pxp\Page\PageDirector();
        $dynamic_builder = new \Pxp\Page\Builder\DynamicBuilder();
        $page_results = (string) $director->build($dynamic_builder, $parameters);

        // build static page containing desired output
        $parameters['filename'] = __DIR__ . '/../examples/ConditionExample/output.html';
        $static_builder = new \Pxp\Page\Builder\StaticBuilder();
        $page_check = (string) $director->build($static_builder, $parameters);

        // compare the two
        $this->assertEquals($page_check, $page_results);
    }
}
