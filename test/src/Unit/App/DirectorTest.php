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

use LivingMarkup\Configuration;
use PHPUnit\Framework\TestCase;
use LivingMarkup\Builder\DynamicPageBuilder;
use LivingMarkup\Engine;
use LivingMarkup\Kernel;

final class KernelTest extends TestCase
{
    public function testCanBuildPage()
    {
        $config = new Configuration('test/config.yml');
        $config->add('filename', __DIR__ . DIRECTORY_SEPARATOR);

        $builder = new DynamicPageBuilder();
        $new_page = (new Kernel())->build($builder, $config);

        // TODO: assure this is correct class
        $this->assertInstanceOf(Engine::class, $new_page);
    }
}
