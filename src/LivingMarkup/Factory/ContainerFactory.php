<?php

declare(strict_types=1);

namespace LivingMarkup\Factory;

use LivingMarkup\Contract\AbstractFactoryInterface;
use Pimple\Container;

class ContainerFactory
{
    /**
     * @param AbstractFactoryInterface $abstractFactory
     * @param string|null $configFilePath
     * @return Container
     */
    public static function buildContainer(
        AbstractFactoryInterface $abstractFactory,
        ?string $configFilePath = null
    ): Container {
        $container = new Container();

        $container['config'] = $abstractFactory->makeConfig($configFilePath);

        $container['document'] = $abstractFactory->makeDocument($container);

        $container['dom_xpath'] = $abstractFactory->makeDomXpath($container);

        $container['element_pool'] = $abstractFactory->makeElementPool();

        $container['engine'] = $abstractFactory->makeEngine($container);

        $container['builder'] = $abstractFactory->makeBuilder($container);

        $container['kernel'] = $abstractFactory->makeKernel($container);

        return $container;
    }
}
