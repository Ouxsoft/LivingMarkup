<?php

namespace LivingMarkup\Contract;

use LivingMarkup\Engine;


interface KernelInterface
{
    /**
     * @param ConfigurationInterface $config
     */
    public function setConfig(ConfigurationInterface $config): void;

    /**
     * @param string $builder_class
     * @return mixed
     */
    public function setBuilder(string $builder_class);

    /**
     * @return Engine
     */
    public function build(): Engine;
}
