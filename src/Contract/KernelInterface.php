<?php
/*
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ouxsoft\LivingMarkup\Contract;

use Ouxsoft\LivingMarkup\Engine;

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
