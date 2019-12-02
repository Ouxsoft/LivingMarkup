<?php

namespace Pxp\Tests;

use PHPUnit\Framework\TestCase;

class DirectorTest extends TestCase
{

    public function testCanBuildPage()
    {
        $page_builder = new \Pxp\Page\Builder\PageBuilder();
        $new_page = (new \Pxp\Page\PageDirector())->build($page_builder);

        $this->assertInstanceOf(Page::class, $new_page);
    }
}