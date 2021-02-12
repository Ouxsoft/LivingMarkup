<?php
/*
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Ouxsoft\LivingMarkup\Factory;

use Ouxsoft\LivingMarkup\Processor;

class ProcessorFactory
{
    /**
     * @return Processor
     */
    public static function getInstance(): Processor
    {
        $abstractFactory = new ConcreteFactory();

        $container = ContainerFactory::buildContainer($abstractFactory);

        return new Processor(
            $container['kernel'],
            $container['config']
        );
    }
}
