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

/**
 * Class Builder
 *
 * The Builder receives parameters passed from the Kernel and uses them to instantiate and return a
 * Document object.
 *
 * @package Ouxsoft\LivingMarkup\Page\Builder
 */
interface BuilderInterface
{
    public function __construct(EngineInterface &$engine, ConfigurationInterface &$config);

    public function createObject(): void;

    public function getObject(): Engine;
}
