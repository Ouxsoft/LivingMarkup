<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Tests;

use PHPUnit\Framework\TestCase;
use LivingMarkup\Processor;

final class ProcessorTest extends TestCase
{
    public function testParseStringWithLoadConfig()
    {
        $proc = new Processor();

        $proc->loadConfig(dirname(__DIR__, 1) . '/Resource/config/phpunit.yml');

        $test_results =  $proc->parseString('<html><bitwise>
    <arg name="number">2</arg>
    <arg name="count">6</arg>
    <arg name="operator">^</arg>
</bitwise></html>');

        $this->assertStringMatchesFormatFile(dirname(__DIR__, 1) . '/Resource/outputs/index.html', $test_results);
    }

    public function testParseFileWithLoadConfig()
    {
        $proc = new Processor();

        $proc->loadConfig(dirname(__DIR__, 1) . '/Resource/config/phpunit.yml');

        $test_results = $proc->parseFile(dirname(__DIR__, 1) . '/Resource/inputs/index.html');

        $this->assertStringMatchesFormatFile(dirname(__DIR__, 1) . '/Resource/outputs/index.html', $test_results);
    }

    public function testParseWithDefinitions()
    {
        $proc = new Processor();

        $proc->addObject('Bitwise', '//bitwise', 'LivingMarkup\Test\Bitwise');

        $proc->addMethod('onRender', 'Execute for render', 'RETURN_CALL');

        $test_results = $proc->parseFile(dirname(__DIR__, 1) . '/Resource/inputs/index.html');

        $this->assertStringMatchesFormatFile(dirname(__DIR__, 1) . '/Resource/outputs/index.html', $test_results);
    }
}
