<?php

declare(strict_types=1);

namespace LivingMarkup\Factory;

use LivingMarkup\Processor;

class ProcessorFactory
{
    /**
     * @param string|null $configPath
     * @return Processor
     */
    public static function getInstance(?string $configPath = null): Processor
    {
        $abstractFactory = new ConcreteFactory();

        $container = ContainerFactory::buildContainer($abstractFactory);

        return new Processor(
            $container['kernel'],
            $container['config']
        );
    }
}
