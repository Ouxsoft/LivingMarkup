<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Tests\Unit\Builder;

use LivingMarkup\Builder\StaticPageBuilder;
use LivingMarkup\Factory\ProcessorFactory;
use PHPUnit\Framework\TestCase;

class StaticPageBuilderTest extends TestCase
{
    private $processor;

    public function setUp(): void
    {
        $this->processor = ProcessorFactory::getInstance();
        $this->processor->loadConfig(TEST_DIR . '/Resource/config/phpunit.json');
        $this->processor->setBuilder('StaticPageBuilder');
    }

    public function tearDown(): void
    {
        unset($this->processor);
    }

    /**
     * @covers \LivingMarkup\Builder\StaticPageBuilder::__construct
     */
    public function test__construct()
    {
        $builder = $this->processor->getBuilder();
        $this->assertInstanceOf(StaticPageBuilder::class,$builder);
    }

    /**
     * @covers \LivingMarkup\Builder\StaticPageBuilder::getObject
     */
    public function testGetObject()
    {
        $test_results = $this->processor->parseFile(TEST_DIR . 'Resource/inputs/index.html');

        $this->assertStringMatchesFormatFile(
            TEST_DIR . 'Resource/outputs/static-page.html',
            $test_results
        );
    }

    /**
     * @covers \LivingMarkup\Builder\StaticPageBuilder::createObject
     */
    public function testCreateObject()
    {
        $test_results = $this->processor->parseFile(TEST_DIR . 'Resource/inputs/index.html');

        $this->assertStringMatchesFormatFile(
            TEST_DIR . 'Resource/outputs/static-page.html',
            $test_results
        );
    }
}