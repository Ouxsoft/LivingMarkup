<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Builder;

use LivingMarkup\Configuration;

/**
 * Class Builder
 * @package LivingMarkup\Page\Builder
 */

interface BuilderInterface
{
    public function createObject(Configuration $config) : ?bool;
    public function getObject() : ?object;
}
