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
use LivingMarkup\Builder\DynamicPageBuilder;
use LivingMarkup\Engine;
use LivingMarkup\Kernel;

final class KernelTest extends TestCase
{
    public function testCanBuildPage()
    {

        $config_dir = dirname(__DIR__, 1) . '/inputs/phpunit.yml';

        $config = new Configuration($config_dir);
        $config->add('filename', 'test/src/Unit/inputs/index.html');

        $builder = new DynamicPageBuilder();
        $new_page = (new Kernel())->build($builder, $config);

        // TODO: assure this is correct class
        $this->assertInstanceOf(Engine::class, $new_page);
    }
}
