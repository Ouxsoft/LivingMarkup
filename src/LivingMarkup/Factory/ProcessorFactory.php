<?php

declare(strict_types=1);

namespace LivingMarkup\Factory;

use LivingMarkup\Processor;

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
