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

namespace LivingMarkup;

use ArrayAccess;

/**
 * Class ArgumentArray
 *
 * @package LivingMarkup
 */
class ArgumentArray implements
    ArrayAccess,
    \Countable
{
    private $container = [];

    /**
     * Returns count of containers
     * @return int
     */
    public function count() : int
    {
        return count($this->container);
    }

    /**
     * Check if item exists inside container
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * Get item from container
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Adds new item to array, if only one item in array then it will be a string
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        if (!isset($this->container[$offset])) {
            // set value
            $this->container[$offset] = $value;
        } elseif ($this->container[$offset] == $value) {
            // if item value exists as string skip
        } elseif (is_string($this->container[$offset])) {
            // change string value to array
            $present_value = $this->container[$offset];
            $this->container[$offset] = [];
            array_push($this->container[$offset], $present_value);
            array_push($this->container[$offset], $value);
        } elseif (in_array($value, $this->container[$offset])) {
            // if item already exists return
            return;
        } elseif (is_array($this->container[$offset])) {
            // add to array
            array_push($this->container[$offset], $value);
        }
    }

    /**
     * Remove item from container
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * Return container property
     *
     * @return array
     */
    public function get(): array
    {
        return $this->container;
    }

    /**
     * Merge array passed with container property
     *
     * @param $array
     */
    public function merge($array) : void
    {
        $this->container = array_merge($array, $this->container);
    }
}
