<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Command\LintCommand;

class ModuleTest extends TestCase
{

    /**
     * @covers \LivingMarkup\Module::getArgByName
     */
    public function testGetArgByName()
    {
        $module = new \LivingMarkup\Test\HelloWorld();

    }

    /**
     * @covers \LivingMarkup\Module::__construct
     */
    public function test__construct()
    {

    }

    /**
     * @covers \LivingMarkup\Module::onRender
     */
    public function testOnRender()
    {

    }

    /**
     * @covers \LivingMarkup\Module::__invoke
     */
    public function test__invoke()
    {

    }

    /**
     * @covers \LivingMarkup\Module::innerText
     */
    public function testInnerText()
    {

    }

    /**
     * @covers \LivingMarkup\Module::__toString
     */
    public function test__toString()
    {

    }

    /**
     * @covers \LivingMarkup\Module::getArgs
     */
    public function testGetArgs()
    {

    }

    /**
     * @covers \LivingMarkup\Module::getId
     */
    public function testGetId()
    {

    }
}
