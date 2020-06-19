<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Test;

use LivingMarkup\Builder\DynamicPageBuilder;
use LivingMarkup\Builder\StaticPageBuilder;
use LivingMarkup\Processor;
use PHPUnit\Framework\TestCase;

class ProcessorTest extends TestCase
{

    /**
     * @covers \LivingMarkup\Processor::setBuilder
     */
    public function testSetBuilder()
    {
        $builder = new StaticPageBuilder();
        $proc = new Processor();
        $proc->setBuilder($builder);
        $this->assertInstanceOf('\LivingMarkup\Builder\BuilderInterface', $proc->getBuilder());
    }

    /**
     * @covers \LivingMarkup\Processor::getBuilder
     */
    public function testGetBuilder()
    {
        $builder = new StaticPageBuilder();
        $proc = new Processor();
        $proc->setBuilder($builder);
        $this->assertInstanceOf('\LivingMarkup\Builder\BuilderInterface', $proc->getBuilder());
    }

    /**
     * @covers \LivingMarkup\Processor::parseFile
     */
    public function testParseFile()
    {

    }

    /**
     * @covers \LivingMarkup\Processor::loadConfig
     */
    public function testLoadConfig()
    {

    }

    /**
     * @covers \LivingMarkup\Processor::getConfig
     */
    public function testGetConfig()
    {
        $proc = new Processor();
        $config = $proc->getConfig();
        $this->assertIsArray($config->config['modules']);
    }


    /**
     * @covers \LivingMarkup\Processor::addObject
     */
    public function testAddObject()
    {

    }

    /**
     * @covers \LivingMarkup\Processor::parseString
     */
    public function testParseString()
    {

    }

    /**
     * @covers \LivingMarkup\Processor::addModule
     */
    public function testAddModule()
    {

    }

    /**
     * @covers \LivingMarkup\Processor::__construct
     */
    public function test__construct()
    {
        $proc = new Processor(dirname(__DIR__, 1) . '/Resources/config/phpunit.yml');
        $this->assertIsObject($proc);
    }

    /**
     * @covers \LivingMarkup\Processor::parseBuffer
     */
    public function testParseBuffer()
    {
        /*
        $proc = new Processor();
        $proc->parseBuffer();
        echo '<html><b>Test</b></html>';
        $output = ob_get_contents();
        echo $output;
*/
    }
}
