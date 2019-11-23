<?php 

namespace Pxp\Tests;

use PHPUnit\Framework\TestCase;

class DirectorTest extends TestCase
{
    public function testCanBuildPage()
    {
        $pageBuilder = new PageBuilder();
        $newPage = (new Director())->build($pageBuilder);
        
        $this->assertInstanceOf(Page::class, $newPage);
        
    }
}