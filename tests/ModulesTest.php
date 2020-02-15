<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Tests;

use PHPUnit\Framework\TestCase;
use LivingMarkup\Builder\DynamicPageBuilder;
use LivingMarkup\Engine;
use LivingMarkup\Module;

final class ModulesTest extends TestCase
{
    public function testCanBuildPage()
    {
        $config = \LivingMarkup\Configuration::load(__DIR__ . DIRECTORY_SEPARATOR . 'config.yml');

        foreach ($config['modules']['types'] as $module) {

            // skip variable named classes, for now
            if (strpos($module['class_name'], '{name}')) {
                continue;
            }

            $module = new $module['class_name'];

            $this->assertInstanceOf(Module::class, $module);
        }
    }
}
