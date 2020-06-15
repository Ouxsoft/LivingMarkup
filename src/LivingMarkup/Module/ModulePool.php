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

namespace LivingMarkup\Module;

use \ArrayIterator;
use LivingMarkup\Module;

/**
 * Class ModulePool
 *
 * Stores and retrieves individual modules
 *
 * @package LivingMarkup
 */
class ModulePool implements \IteratorAggregate
{
    public $collection = [];

    /**
     * Iterator to go through module pool
     *
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->collection);
    }

    /**
     * Get Module by placeholder id
     *
     * @param string|null $module_id
     * @return Module|null
     */
    public function getById(?string $module_id = null) : ?Module
    {
        if (array_key_exists($module_id, $this->collection)) {
            return $this->collection[$module_id];
        }

        return null;
    }


    /**
     * Get the public properties of a module using the modules ID
     *
     * @param string $module_id
     * @return array
     */
    public function getPropertiesByID(string $module_id) : array
    {
        return get_object_vars($this->collection[$module_id]);
    }

    /**
     * Add new module to pool
     *
     * @param $module
     */
    public function add(Module &$module) : void
    {
        $this->collection[$module->module_id] = $module;
    }

    /**
     * Invoke a method if present in each module
     *
     *
     * @param $method
     */
    public function callMethod(string $method) : void
    {
        // iterate through elements
        foreach ($this->collection as $module) {
            $module($method);
        }
    }
}
