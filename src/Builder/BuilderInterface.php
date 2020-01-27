<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pxp\Builder;

/**
 * Class Builder
 * @package Pxp\Page\Builder
 */

interface BuilderInterface {
    public function createObject(array $parameters) : ?bool;
    public function getObject() : ?object;
}