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
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{

    public function testAddModule()
    {
        $config = new Configuration();
        $config->addModule([
            'name' => 'Bitwise',
            'class_name' => 'LivingMarkup\Test\Bitwise',
            'xpath' => 'bitwise'
        ]);
        $this->assertCount(1, $config->config['modules']['types']);
    }

    public function testGetModules()
    {
        $module = [
            'name' => 'Bitwise',
            'class_name' => 'LivingMarkup\Test\Bitwise',
            'xpath' => 'bitwise'
        ];
        $config = new Configuration();
        $config->addModule($module);
        $results = $config->getModules();

        $this->assertCount(0, array_diff_assoc($results[0],$module));
    }

    public function testIsset()
    {
        $config = new Configuration();
        $results = $config->isset('version');
        $this->assertTrue($results);
    }

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

        $this->assertCount(0, array_diff_assoc($methods[0],$test_compare[0]));
    }

    public function testGetMethods()
    {
        $test_method = [
            'name' => 'onLoad',
            'descirption' => 'Execute when object data is loading'
        ];
        $config = new Configuration();
        $config->config['modules']['methods'] = $test_method;
        $methods = $config->getMethods();
        $this->assertCount(0,array_diff_assoc($methods,$test_method));
    }

    public function testGetSource()
    {
        $test_string = '<html><p>Hello, World!</p></html>';
        $config = new Configuration();
        $config->setSource($test_string);
        $source = $config->getSource();
        $this->assertEquals($test_string, $source);
    }

    public function testAdd()
    {
        $config = new Configuration();
        $config->add('test', 'yes');
        $this->assertStringContainsString('yes', $config->config['test']);
    }

    public function testSetSource()
    {
        $markup = '<html><p>Hello, World!</p></html>';
        $config = new Configuration();
        $config->setSource($markup);
        $this->assertStringContainsString($markup, $config->config['markup']);
    }

    public function testAddModules()
    {
        $config = new Configuration();
        $config->addModules([
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
        $this->assertCount(2, $config->config['modules']['types']);
    }

    public function testLoadFile()
    {
        $config_dir = dirname(__DIR__, 1) . '/inputs/phpunit.yml';
        $config = new Configuration($config_dir);
        $this->assertArrayHasKey('modules', $config->config);
    }
}