<?php

namespace LivingMarkup\Contract;

use LivingMarkup\Engine;

interface KernelInterface
{
    public function __construct(
        EngineInterface &$engine,
        BuilderInterface &$builder,
        ConfigurationInterface &$config
    );

    public function getConfig(): ConfigurationInterface;

    public function setConfig(ConfigurationInterface $config): void;

    public function getBuilder(): BuilderInterface;

    public function setBuilder(string $builder_class): void;

    public function build(): Engine;

}
