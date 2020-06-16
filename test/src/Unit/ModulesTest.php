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
use LivingMarkup\Configuration;
use LivingMarkup\Module;

final class ModulesTest extends TestCase
{
    public function testCanBuildPage()
    {
        $config = new Configuration();
        $config->loadFile('test/src/Resources/config/phpunit.yml');

        foreach ($config->getModules() as $module) {

            // skip variable named classes, for now
            if (strpos($module['class_name'], '{name}')) {
                continue;
            }

            $module = new $module['class_name'];

            $this->assertInstanceOf(Module::class, $module);
        }
    }
}
