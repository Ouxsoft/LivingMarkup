<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Tests;

use PHPUnit\Framework\TestCase;
use LivingMarkup\Builder\DynamicPageBuilder;
use LivingMarkup\Engine;
use LivingMarkup\Director;

final class DirectorTest extends TestCase
{
    public function testCanBuildPage()
    {
        $parameters = [
            'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'pages/index.html',
            'handlers' => [
                '//img'         => 'LivingMarkup\Component\Img',
                '//a'           => 'LivingMarkup\Component\A',
                '//var'         => 'LivingMarkup\Component\Variable',
                '//condition'   => 'LivingMarkup\Component\Condition',
                '//redact'    => 'LivingMarkup\Component\Redact'
            ],
            'hooks' => [
                'beforeLoad'    => 'Executed before onLoad',
                'onLoad'        => 'Loads object data',
                'afterLoad'     => 'Executed after onLoad',
                'beforeRender'  => 'Executed before onLoad',
                'onRender'      => 'RETURN_CALL',
                'afterRender'   => 'Executed after onRender',
            ]
        ];

        $builder = new DynamicPageBuilder();
        $new_page = (new Director())->build($builder, $parameters);

        // TODO: assure this is correct class
        $this->assertInstanceOf(Engine::class, $new_page);
    }
}
