<?php
// ./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/DirectorTest

declare(strict_types=1);

namespace Pxp\Tests;

use PHPUnit\Framework\TestCase;

final class DirectorTest extends TestCase
{

    public function testCanBuildPage()
    {
        $parameters = [
            'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'pages/index.html',
            'handlers' => [
                '//img'         => 'Pxp\DynamicElement\Img',
                '//a'           => 'Pxp\DynamicElement\A',
                '//var'         => 'Pxp\DynamicElement\Variable',
                '//condition'   => 'Pxp\DynamicElement\Condition',
                '//redacted'    => 'Pxp\DynamicElement\Redacted'
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

        $page_builder = new \Pxp\Page\Builder\DynamicBuilder();
        $new_page = (new \Pxp\Page\PageDirector())->build($page_builder, $parameters);

        // TODO: assure this is correct class
        $this->assertInstanceOf(\PXP\Page\Page::class, $new_page);
    }
}