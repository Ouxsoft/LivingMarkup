<?php

declare(strict_types=1);

namespace LivingMarkup\Factory;

use LivingMarkup\Contract\AbstractFactoryInterface;
use Pimple\Container;

class ContainerFactory
{
    /**
     * @param AbstractFactoryInterface $abstractFactory
     * @return Container
     */
    public static function buildContainer(
        AbstractFactoryInterface $abstractFactory
    ): Container
    {
        $container = new Container();

        $container['document'] = $abstractFactory->makeDocument($container);

        $container['config'] = $abstractFactory->makeConfig($container);

        $container['element_pool'] = $abstractFactory->makeElementPool();

        $container['engine'] = $abstractFactory->makeEngine($container);

        $container['builder'] = $abstractFactory->makeBuilder($container);

        $container['kernel'] = $abstractFactory->makeKernel($container);

        return $container;
    }
}
