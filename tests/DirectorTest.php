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
use Pxp\Builder\DynamicPageBuilder;
use Pxp\Page\Page;
use Pxp\Director;

final class DirectorTest extends TestCase
{
    public function testCanBuildPage()
    {
        $parameters = [
            'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'pages/index.html',
            'handlers' => [
                '//img'         => 'Pxp\Component\Img',
                '//a'           => 'Pxp\Component\A',
                '//var'         => 'Pxp\Component\Variable',
                '//condition'   => 'Pxp\Component\Condition',
                '//redacted'    => 'Pxp\Component\Redacted'
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
        $this->assertInstanceOf(Page::class, $new_page);
    }
}
