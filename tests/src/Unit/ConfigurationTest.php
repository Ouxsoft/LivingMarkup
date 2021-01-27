<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Tests\Unit;

use LivingMarkup\Configuration;
use LivingMarkup\Exception\Exception;
use LivingMarkup\Factory\ContainerFactory;
use LivingMarkup\Factory\ConcreteFactory;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    private $config;

    public function setUp(): void
    {
        $abstractFactory = new ConcreteFactory();
        $container = ContainerFactory::buildContainer($abstractFactory);
        $this->config = &$container['config'];
    }

    public function tearDown(): void
    {
        unset($this->config);
    }

    /**
     * @covers \LivingMarkup\Configuration::addElement
     */
    public function testAddElement()
    {
        $this->config->addElement([
            'name' => 'Bitwise',
            'class_name' => 'LivingMarkup\Tests\Resource\Element\Bitwise',
            'xpath' => 'bitwise'
        ]);
        $this->assertCount(1, $this->config->getElements());
    }

    /**
     * @covers \LivingMarkup\Configuration::getElements
     */
    public function testGetElements()
    {
        $element = [
            'name' => 'Bitwise',
            'class_name' => 'LivingMarkup\Tests\Resource\Element\Bitwise',
            'xpath' => 'bitwise'
        ];
        $this->config->addElement($element);
        $results = $this->config->getElements();
        $this->assertCount(0, array_diff_assoc($results[0], $element));

/*
        // check for empty array
        unset($config->container);
        $elements = $config->getElements();
        $this->assertCount(0, $elements);
*/
    }

    /**
     * @covers \LivingMarkup\Configuration::isset
     */
    public function testIsset()
    {
        // does exists
        $results = $this->config->isset('version');
        $this->assertTrue($results);

        // does not exists
        $results = $this->config->isset('does not exist');
        $this->assertFalse($results);
    }

    /**
     * @covers \LivingMarkup\Configuration::addRoutine
     */
    public function testAddRoutine()
    {
        $this->config->addRoutine('onLoad', 'Execute when object data is loading');
        $routines = $this->config->getRoutines();
        $test_compare = [
            0 => [
                'name' => 'onLoad',
                'description' => 'Execute when object data is loading'
            ]
        ];

        $this->assertCount(0, array_diff_assoc($routines[0], $test_compare[0]));
    }

    /**
     * @covers \LivingMarkup\Configuration::getRoutines
     */
    public function testGetRoutines()
    {
        $test_routine = [
            'name' => 'onLoad',
            'description' => 'Execute when object data is loading'
        ];
        $this->config->addRoutine($test_routine['name'],$test_routine['description']);
        $routines = $this->config->getRoutines();
        $this->assertCount(0, array_diff_assoc($routines, $test_routine));

        unset($this->config->routines);
        $routines = $this->config->getRoutines();
        $this->assertCount(0, $routines);

    }

    /**
     * @covers \LivingMarkup\Configuration::getMarkup
     */
    public function testGetMarkup()
    {
        $test_string = '<html><p>Hello, World!</p></html>';
        $this->config->setMarkup($test_string);
        $source = $this->config->getMarkup();
        $this->assertEquals($test_string, $source);

        // test if not exists
        unset($this->config->markup);
        $this->assertTrue($this->config->getMarkup() == '');
    }

    /**
     * @covers \LivingMarkup\Configuration::__set
     */
    public function test__set()
    {
        $source = '<html lang="en">Test</html>';
        $this->config->markup = $source;
        $this->assertStringContainsString($source, $this->config->getMarkup());

        $source = '<html lang="en">Test</html>';
        $this->config->markup = $source;
        $this->assertStringContainsString($source, $this->config->getMarkup());

    }

    /**
     * @covers \LivingMarkup\Configuration::__get
     */
    public function test__get()
    {
        $source = '<html lang="en">Test</html>';
        $this->config->markup = $source;
        $this->assertStringContainsString($source, $this->config->markup);

        $this->config->routines[] = [
            'name' => 'Bitwise',
            'class_name' => 'LivingMarkup\Tests\Resource\Element\Bitwise',
            'xpath' => 'bitwise'
        ];
        $this->asserArrayHasKey(0, $this->config->routines);

    }

    /**
     * @covers \LivingMarkup\Configuration::setMarkup
     */
    public function testSetMarkup()
    {
        $markup = '<html><p>Hello, World!</p></html>';
        $this->config->setMarkup($markup);
        $this->assertStringContainsString($markup, $this->config->getMarkup());
    }

    /**
     * @covers \LivingMarkup\Configuration::addElements
     */
    public function testAddElements()
    {
        $this->config->addElements([
            [
                'name' => 'Bitwise',
                'class_name' => 'LivingMarkup\Tests\Resource\Element\Bitwise',
                'xpath' => 'bitwise'
            ],
            [
                'name' => 'Bitwise',
                'class_name' => 'LivingMarkup\Tests\Resource\Element\Bitwise',
                'xpath' => 'bitwise'
            ]
        ]);
        $this->assertCount(2, $this->config->container['elements']['types']);
    }

    /**
     * @covers \LivingMarkup\Configuration::loadFile
     */
    public function testLoadFile()
    {
        $this->config->loadFile(TEST_DIR . 'Resource/inputs/phpunit.json');
        $this->assertArrayHasKey('elements', $this->config->getElements());

        $this->expectException(Exception::class);
        $this->config->loadFile('DoesNot.Exists');

    }
}
