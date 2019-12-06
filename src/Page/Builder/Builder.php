<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <contact@mrheroux.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pxp\Page\Builder;

/**
 * Class Builder
 * @package Pxp\Page\Builder
 */
abstract class Builder
{
    /**
     * Creates object using parameters supplied
     *
     * @param $parameters
     * @return bool|null
     */
    abstract public function createObject(array $parameters) : ?bool;

    /**
     * Returns object
     *
     * @return object|null
     */
    abstract public function getObject() : ?object;
}
