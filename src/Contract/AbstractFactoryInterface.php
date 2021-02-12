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

use Ouxsoft\LivingMarkup\Contract\BuilderInterface;
use Ouxsoft\LivingMarkup\Configuration;
use Ouxsoft\LivingMarkup\Document;
use Ouxsoft\LivingMarkup\Element\ElementPool;
use Ouxsoft\LivingMarkup\Engine;
use Ouxsoft\LivingMarkup\Kernel;
use Pimple\Container;

/**
 * Interface AbstractFactoryInterface
 * @package Ouxsoft\LivingMarkup\Contract
 */
interface AbstractFactoryInterface
{
    /**
     * @param Container $container
     * @return Document
     */
    public function makeDocument(Container &$container): DocumentInterface;

    /**
     * @param Container $container
     * @return Configuration
     */
    public function makeConfig(Container &$container): Configuration;

    /**
     * @return ElementPool
     */
    public function makeElementPool(): ElementPool;

    /**
     * @param Container $container
     * @return BuilderInterface
     */
    public function makeBuilder(Container &$container): BuilderInterface;

    /**
     * @param Container $container
     * @return Engine
     */
    public function makeEngine(Container &$container): Engine;

    /**
     * @param Container $container
     * @return Kernel
     */
    public function makeKernel(Container &$container): Kernel;
}
