<?php
/*
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ouxsoft\LivingMarkup\Tests\Feature;

use Ouxsoft\LivingMarkup\Factory\ProcessorFactory;
use Ouxsoft\LivingMarkup\Processor;
use PHPUnit\Framework\TestCase;

final class ProcessorTest extends TestCase
{
    /**
     * @var Processor
     */
    private $processor;

    public function setUp(): void
    {
        $this->processor = ProcessorFactory::getInstance();
    }

    public function tearDown(): void
    {
        unset($this->processor);
    }

    public function testParseStringWithLoadConfig()
    {

        $this->processor->loadConfig(TEST_DIR . 'Resource/config/phpunit.json');

        $html = file_get_contents(TEST_DIR . 'Resource/inputs/index.html');

        $test_results = $this->processor->parseString($html);

        $this->assertStringMatchesFormatFile(
            TEST_DIR . 'Resource/outputs/index.html',
            $test_results
        );
    }

    public function testParseFileWithLoadConfig()
    {

        $this->processor->loadConfig(TEST_DIR . 'Resource/config/phpunit.json');

        $test_results = $this->processor->parseFile(TEST_DIR . 'Resource/inputs/index.html');

        $this->assertStringMatchesFormatFile(
            TEST_DIR . 'Resource/outputs/index.html',
            $test_results
        );
    }

    public function testParseWithDefinitions()
    {
        $this->processor->addElement([
            'name' => 'Bitwise',
            'xpath' => '//bitwise',
            'class_name' => 'Ouxsoft\LivingMarkup\Tests\Resource\Element\Bitwise'
        ]);

        $this->processor->addRoutine([
            'method' => 'onRender',
            'description' => 'Execute while object is rendering',
            'execute' => 'RETURN_CALL'
        ]);

        $test_results = $this->processor->parseFile(TEST_DIR . 'Resource/inputs/index.html');

        $this->assertStringMatchesFormatFile(
            TEST_DIR . 'Resource/outputs/index.html',
            $test_results
        );
    }
}