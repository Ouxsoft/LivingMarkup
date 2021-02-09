<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ouxsoft\LivingMarkup\Tests\Unit;

use Ouxsoft\LivingMarkup\Contract\BuilderInterface;
use Ouxsoft\LivingMarkup\Contract\ConfigurationInterface;
use Ouxsoft\LivingMarkup\Builder\StaticPageBuilder;
use Ouxsoft\LivingMarkup\Configuration;
use Ouxsoft\LivingMarkup\Document;
use Ouxsoft\LivingMarkup\Factory\ProcessorFactory;
use PHPUnit\Framework\TestCase;

class ProcessorTest extends TestCase
{
    private $processor;

    public function setUp(): void
    {
        $this->processor = ProcessorFactory::getInstance();
    }

    public function tearDown(): void
    {
        unset($this->processor);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Processor::setBuilder
     */
    public function testSetBuilder()
    {
        $this->processor->setBuilder('StaticPageBuilder');
        $processor_builder = $this->processor->getBuilder();
        $this->assertInstanceOf(StaticPageBuilder::class, $processor_builder);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Processor::getBuilder
     */
    public function testGetBuilder()
    {
        $processor_builder = $this->processor->getBuilder();
        $this->assertInstanceOf(BuilderInterface::class, $processor_builder);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Processor::parseFile
     */
    public function testParseFile()
    {
        $this->processor->loadConfig(TEST_DIR . '/Resource/config/phpunit.json');
        $test_results = $this->processor->parseFile(TEST_DIR . '/Resource/inputs/index.html');
        $this->assertStringMatchesFormatFile(TEST_DIR . '/Resource/outputs/index.html', $test_results);

        // test non html
        $this->processor->loadConfig(TEST_DIR . '/Resource/config/phpunit.json');
        $test_results = $this->processor->parseFile(TEST_DIR . '/Resource/inputs/text.txt');
        $this->assertStringMatchesFormatFile(TEST_DIR . '/Resource/outputs/text.txt', $test_results);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Processor::loadConfig
     */
    public function testLoadConfig()
    {
        $this->processor->loadConfig(TEST_DIR . '/Resource/config/phpunit.json');
        $processor_config = $this->processor->getConfig();
        $this->assertInstanceOf(ConfigurationInterface::class, $processor_config);
    }


    /**
     * @covers \Ouxsoft\LivingMarkup\Processor::setConfig
     */
    public function testSetConfig()
    {
        $document = new Document();
        $config = new Configuration(
            $document
        );
        $this->processor->setConfig($config);
        $processor_config = $this->processor->getConfig();
        $this->assertInstanceOf(ConfigurationInterface::class, $processor_config);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Processor::getConfig
     */
    public function testGetConfig()
    {
        $processor_config = $this->processor->getConfig();
        $this->assertInstanceOf(ConfigurationInterface::class, $processor_config);
    }


    /**
     * @covers \Ouxsoft\LivingMarkup\Processor::addElement
     */
    public function testAddElement()
    {
        $this->processor->addElement([
            'name' => 'HelloMyEverything',
            'xpath' => '//*',
            'class_name' => '\LivingMarkup\Tests\Resource\Element\HelloWorld'
        ]);
        $config = $this->processor->getConfig();
        $elements = $config->getElements();
        $this->assertCount(1, $elements);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Processor::addRoutine
     */
    public function testAddRoutine()
    {
        $this->processor->addRoutine([
            'method' => 'TestRoutine'
        ]);
        $config = $this->processor->getConfig();
        $routines = $config->getRoutines();
        $this->assertCount(1, $routines);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Processor::parseString
     */
    public function testParseString()
    {
        $this->processor->loadConfig(TEST_DIR . '/Resource/config/phpunit.json');
        $test_results = $this->processor->parseString('<html lang="en"><bitwise>
    <arg name="number">2</arg>
    <arg name="count">6</arg>
    <arg name="operator">^</arg>
</bitwise></html>');
        $this->assertStringMatchesFormatFile(TEST_DIR . '/Resource/outputs/index.html', $test_results);

        // test non html
        $test_results = $this->processor->parseString('???');
        $this->assertStringContainsString('???', $test_results);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Processor::__construct
     */
    public function test__construct()
    {
        $this->assertIsObject($this->processor);

        $config = $this->processor->getConfig();
        $this->assertInstanceOf(ConfigurationInterface::class, $config);

        $builder = $this->processor->getBuilder();
        $this->assertInstanceOf(BuilderInterface::class, $builder);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Processor::parseBuffer
     */
    public function testParseBuffer()
    {

        $this->processor->parseBuffer();
        $input = '<html lang="en"><b>Test</b></html>';
        echo $input;
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertStringContainsString($output, $input);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Processor::parseBuffer
     * @covers \Ouxsoft\LivingMarkup\Processor::parse
     */
    public function testParseBufferWithProcessorOff()
    {
        // try with processor turned off
        $this->processor->setStatus(true);
        $this->processor->parseBuffer();
        $input = '<html lang="en"><b>Test</b></html>';
        echo $input;
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertStringContainsString($output, $input);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Processor::setStatus
     */
    public function testSetStatus()
    {

        $this->processor->setStatus(false);
        $status = $this->processor->getStatus();
        $this->assertFalse($status);

        $this->processor->setStatus(true);
        $status = $this->processor->getStatus();
        $this->assertTrue($status);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Processor::getStatus
     */
    public function testGetStatus()
    {
        $this->processor->setStatus(false);
        $status = $this->processor->getStatus();
        $this->assertFalse($status);
    }
}
