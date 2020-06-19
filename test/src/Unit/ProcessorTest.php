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
        $proc = new Processor();
        $proc->loadConfig(dirname(__DIR__, 1) . '/Resources/config/phpunit.yml');
        $test_results = $proc->parseFile(dirname(__DIR__, 1) . '/Resources/inputs/index.html');
        $this->assertStringMatchesFormatFile(dirname(__DIR__, 1) . '/Resources/outputs/index.html', $test_results);

        // test non html
        $proc = new Processor();
        $proc->loadConfig(dirname(__DIR__, 1) . '/Resources/config/phpunit.yml');
        $test_results = $proc->parseFile(dirname(__DIR__, 1) . '/Resources/inputs/text.txt');
        $this->assertStringMatchesFormatFile(dirname(__DIR__, 1) . '/Resources/outputs/text.txt', $test_results);
    }

    /**
     * @covers \LivingMarkup\Processor::loadConfig
     */
    public function testLoadConfig()
    {
        $proc = new Processor();
        $proc->loadConfig(dirname(__DIR__, 1) . '/Resources/config/phpunit.yml');
        $config = $proc->getConfig();
        $this->assertIsArray($config->config['modules']);
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
        $proc = new Processor();
        $proc->addObject('Path', '//*', '\LivingMarkup\Test\HelloWorld');
        $config = $proc->getConfig();
        $modules = $config->getModules();
        $this->assertCount(1, $modules);
    }

    /**
     * @covers \LivingMarkup\Processor::parseString
     */
    public function testParseString()
    {
        $proc = new Processor();
        $proc->loadConfig(dirname(__DIR__, 1) . '/Resources/config/phpunit.yml');
        $test_results = $proc->parseString('<html><bitwise>
    <arg name="number">2</arg>
    <arg name="count">6</arg>
    <arg name="operator">^</arg>
</bitwise></html>');
        $this->assertStringMatchesFormatFile(dirname(__DIR__, 1) . '/Resources/outputs/index.html', $test_results);

        // test non html
        $test_results = $proc->parseString('???');
        $this->assertStringContainsString('???', $test_results);
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
        // process
        $proc = new Processor();
        $proc->parseBuffer();
        $input = '<html><b>Test</b></html>';
        echo $input;
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertStringContainsString($output, $input);
    }

    /**
     * @covers \LivingMarkup\Processor::parseBuffer
     */
    public function testParseBufferWithProcessorOff(){

        // try with processor turned off
        $proc = new Processor();
        $proc->setStatus(true);
        $proc->parseBuffer();
        $input = '<html><b>Test</b></html>';
        echo $input;
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertStringContainsString($output, $input);
    }


    /**
     * @covers \LivingMarkup\Processor::setStatus
     */
    public function testSetStatus(){
        $proc = new Processor();
        $proc->setStatus(false);
        $status = $proc->getStatus();
        $this->assertFalse($status);
    }


    /**
     * @covers \LivingMarkup\Processor::getStatus
     */
    public function testGetStatus(){
        $proc = new Processor();
        $proc->setStatus(false);
        $status = $proc->getStatus();
        $this->assertFalse($status);
    }
}
