<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup;

/**
 * Class PrunedList
 * @package LivingMarkup
 */
class PrunedList
{
    private $list = [];

    /**
     * Add an item to the list property, if not present
     * arrays with only one item are stored as strings
     *
     * @param $index
     * @param $value
     */
    public function add($index, $value) : void
    {
        if (!isset($this->list[$index])) {
            // set value
            $this->list[$index] = $value;
        } elseif ($this->list[$index] == $value) {
            // if item value exists as string skip
        } elseif (is_string($this->list[$index])) {
            // change string value to array
            $present_value = $this->list[$index];
            $this->list[$index] = [];
            array_push($this->list[$index], $present_value);
            array_push($this->list[$index], $value);
        } elseif (in_array($value, $this->list[$index])) {
            // if item already exists return
            return;
        } elseif (is_array($this->list[$index])) {
            // add to array
            array_push($this->list[$index], $value);
        }
    }

    /**
     * Return list property
     *
     * @return array
     */
    public function get() : array
    {
        return $this->list;
    }

    /**
     * Merge array passed with list property
     *
     * @param $array
     */
    public function merge($array)
    {
        $this->list = array_merge($array, $this->list);
    }
}
