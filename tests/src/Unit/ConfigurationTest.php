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

use Ouxsoft\LivingMarkup\Factory\ContainerFactory;
use Ouxsoft\LivingMarkup\Factory\ConcreteFactory;
use PHPUnit\Framework\TestCase;
use Ouxsoft\LivingMarkup\Exception\Exception;

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
     * @covers \Ouxsoft\LivingMarkup\Configuration::addElement
     */
    public function testAddElement()
    {
        $this->config->addElement([
            'name' => 'Bitwise',
            'class_name' => 'Ouxsoft\LivingMarkup\Tests\Resource\Element\Bitwise',
            'xpath' => 'bitwise'
        ]);
        $this->assertCount(1, $this->config->getElements());
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Configuration::getElements
     */
    public function testGetElements()
    {
        $element = [
            'name' => 'Bitwise',
            'class_name' => 'Ouxsoft\LivingMarkup\Tests\Resource\Element\Bitwise',
            'xpath' => 'bitwise'
        ];
        $this->config->addElement($element);
        $results = $this->config->getElements();
        $this->assertCount(0, array_diff_assoc($results[0], $element));

    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Configuration::addRoutine
     */
    public function testAddRoutine()
    {
        $this->config->addRoutine([
            'method' => 'onLoad',
            'description' => 'Execute when object data is loading'
        ]);
        $routines = $this->config->getRoutines();
        $this->assertCount(1, $routines);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Configuration::getRoutines
     */
    public function testGetRoutines()
    {
        $test_routine = [
            'method' => 'onLoad',
            'description' => 'Execute when object data is loading'
        ];
        $this->config->addRoutine(
            $test_routine
        );
        $routines = $this->config->getRoutines();
        $this->assertCount(1, $routines);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Configuration::getMarkup
     */
    public function testGetMarkup()
    {
        $test_string = '<html lang="en"><p>Hello, World!</p></html>';
        $this->config->setMarkup($test_string);
        $source = $this->config->getMarkup();
        $this->assertEquals($test_string, $source);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Configuration::setMarkup
     */
    public function testSetMarkup()
    {
        $markup = '<html lang="en"><p>Hello, World!</p></html>';
        $this->config->setMarkup($markup);
        $this->assertStringContainsString($markup, $this->config->getMarkup());
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Configuration::addElements
     */
    public function testAddElements()
    {
        $this->config->addElements([
            [
                'name' => 'Bitwise',
                'class_name' => 'Ouxsoft\LivingMarkup\Tests\Resource\Element\Bitwise',
                'xpath' => 'bitwise'
            ],
            [
                'name' => 'HelloWorld',
                'class_name' => 'Ouxsoft\LivingMarkup\Tests\Resource\Element\HelloWorld',
                'xpath' => 'helloworld'
            ]
        ]);
        $this->assertCount(2, $this->config->elements);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Configuration::loadFile
     */
    public function testLoadFile()
    {
        // load file containing elements, this should work
        $this->config->loadFile(TEST_DIR . 'Resource/config/phpunit.json');
        $elements = $this->config->getElements();
        $this->assertNotEmpty($elements);


        // load a file that is invalid, this should not work
        $this->expectException(Exception::class);
        $this->config->loadFile(TEST_DIR . 'Resource/config/invalid.json');

    }
}
