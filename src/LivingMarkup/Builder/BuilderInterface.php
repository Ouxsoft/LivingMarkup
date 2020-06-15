<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace LivingMarkup\Builder;

use LivingMarkup\Configuration;
use LivingMarkup\Engine;

/**
 * Class Builder
 *
 * @package LivingMarkup\Page\Builder
 */

interface BuilderInterface
{
    public function createObject(Configuration $config) : void;
    public function getObject() : Engine;
}
