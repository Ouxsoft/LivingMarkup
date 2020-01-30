<?php

namespace LivingMarkup;
/**
 * Class PrunedList
 * @package LivingMarkup
 */
class PrunedList {

    private $list = [];

    /**
     * Add an item to list property if it does not exist
     * turn arrays with only one item into strings
     *
     * @param $index
     * @param $value
     */
    function add($index, $value) : void {
        if (!isset($this->list[$index])) {
            // set value
            $this->list[$index] = $value;
        } else if ($this->list[$index] == $value) {
            // if item value exists as string skip
        } else if (is_string($this->list[$index])) {
            // change string value to array
            $present_value = $this->list[$index];
            $this->list[$index] = [];
            array_push($this->list[$index], $present_value);
            array_push($this->list[$index], $value);
        } else if (in_array($value, $this->list[$index])) {
            // if item already exists return
            return;
        } else if (is_array($this->list[$index])) {
            // add to array
            array_push($this->list[$index], $value);
        }
    }

    /**
     * Return list property
     *
     * @return array
     */
    function get() : array {
        return $this->list;
    }

    /**
     * Merge array passed with list property
     *
     * @param $array
     */
    function merge($array){
        $this->list = array_merge($array, $this->list);
    }
}