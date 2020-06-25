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

use LivingMarkup\Configuration;
use LivingMarkup\Exception\Exception;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    /**
     * @covers \LivingMarkup\Configuration::addElement
     */
    public function testAddElement()
    {
        $config = new Configuration();
        $config->addElement([
            'name' => 'Bitwise',
            'class_name' => 'LivingMarkup\Test\Bitwise',
            'xpath' => 'bitwise'
        ]);
        $this->assertCount(1, $config->container['elements']['types']);
    }

    /**
     * @covers \LivingMarkup\Configuration::getElements
     */
    public function testGetElements()
    {
        $element = [
            'name' => 'Bitwise',
            'class_name' => 'LivingMarkup\Test\Bitwise',
            'xpath' => 'bitwise'
        ];
        $config = new Configuration();
        $config->addElement($element);
        $results = $config->getElements();
        $this->assertCount(0, array_diff_assoc($results[0], $element));


        // check for empty array
        $config = new Configuration();
        unset($config->container);
        $elements = $config->getElements();
        $this->assertCount(0, $elements);
    }

    /**
     * @covers \LivingMarkup\Configuration::isset
     */
    public function testIsset()
    {
        // does exists
        $config = new Configuration();
        $results = $config->isset('version');
        $this->assertTrue($results);

        // does not exists
        $results = $config->isset('does not exist');
        $this->assertFalse($results);

        // no config
        unset($config->container);
        $results = $config->isset('a', 'b');
        $this->assertFalse($results);
    }

    /**
     * @covers \LivingMarkup\Configuration::addMethod
     */
    public function testAddMethod()
    {
        $config = new Configuration();
        $config->addMethod('onLoad', 'Execute when object data is loading');
        $methods = $config->getMethods();
        $test_compare = [
            0 => [
                'name' => 'onLoad',
                'description' => 'Execute when object data is loading'
            ]
        ];

        $this->assertCount(0, array_diff_assoc($methods[0], $test_compare[0]));
    }

    /**
     * @covers \LivingMarkup\Configuration::getMethods
     */
    public function testGetMethods()
    {
        $test_method = [
            'name' => 'onLoad',
            'descirption' => 'Execute when object data is loading'
        ];
        $config = new Configuration();
        $config->container['elements']['methods'] = $test_method;
        $methods = $config->getMethods();
        $this->assertCount(0, array_diff_assoc($methods, $test_method));

        // test if not exists
        unset($config->container);
        $this->assertCount(0, $config->getMethods());
    }

    /**
     * @covers \LivingMarkup\Configuration::getSource
     */
    public function testGetSource()
    {
        $test_string = '<html><p>Hello, World!</p></html>';
        $config = new Configuration();
        $config->setSource($test_string);
        $source = $config->getSource();
        $this->assertEquals($test_string, $source);

        // test if not exists
        unset($config->container);
        $this->assertTrue(($config->getSource() == ''));
    }

    /**
     * @covers \LivingMarkup\Configuration::add
     */
    public function testAdd()
    {
        $config = new Configuration();
        $config->add('test', 'yes');
        $this->assertStringContainsString('yes', $config->container['test']);
    }

    /**
     * @covers \LivingMarkup\Configuration::setSource
     */
    public function testSetSource()
    {
        $markup = '<html><p>Hello, World!</p></html>';
        $config = new Configuration();
        $config->setSource($markup);
        $this->assertStringContainsString($markup, $config->container['markup']);
    }

    /**
     * @covers \LivingMarkup\Configuration::addElements
     */
    public function testAddElements()
    {
        $config = new Configuration();
        $config->addElements([
            [
                'name' => 'Bitwise',
                'class_name' => 'LivingMarkup\Test\Bitwise',
                'xpath' => 'bitwise'
            ],
            [
                'name' => 'Bitwise',
                'class_name' => 'LivingMarkup\Test\Bitwise',
                'xpath' => 'bitwise'
            ]
        ]);
        $this->assertCount(2, $config->container['elements']['types']);
    }

    /**
     * @covers \LivingMarkup\Configuration::loadFile
     */
    public function testLoadFile()
    {
        $config_dir = dirname(__DIR__, 1) . '/inputs/phpunit.yml';
        $config = new Configuration($config_dir);
        $this->assertArrayHasKey('elements', $config->container);

        $error = false;
        $config = new Configuration();
        try {
            $config->loadFile('invalid');
        } catch (Exception $e) {
            $error = true;
        }
        $this->assertTrue($error);
    }
}
