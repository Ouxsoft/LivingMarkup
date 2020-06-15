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

use \IteratorAggregate;
use \ArrayIterator;

/**
 * Class ModulePool
 *
 * Initializes and retrieves individual modules
 *
 * @package LivingMarkup
 */
class ModulePool implements \IteratorAggregate
{
    public $collection = [];

    // TODO: implement pool design pattern
    private $occupied_modules = [];
    private $free_modules = [];

    public function getIterator() {
        return new \ArrayIterator($this->collection);
    }

    /**
     * Get Module by placeholder id
     *
     * @param string|null $module_id
     * @return object
     */
    public function getById(?string $module_id = null)
    {
        // TODO: Mark as occupied
        if (array_key_exists($module_id, $this->collection)) {
            return $this->collection[$module_id];
        }

        return null;
    }


    public function getPropertiesByID(string $module_id){
        return get_object_vars($this->collection[$module_id]);
    }

    public function add(&$module)
    {
        $this->collection[$module->module_id] = $module;
    }

    // TODO in order for worker concept to work the state and data of the object must be separated from the module

    /**
     * Gets a module or initializes a module if one is not present and free
     *
     * @return Module|mixed
     */
    public function getModule()
    {
        /*
        if (count($this->free_collection) == 0) {
            $id = count($this->occupied_collection) + count($this->free_collection) + 1;
            $randomName = array_rand($this->names, 1);

            $worker = new Module($id, $this->names[$randomName]);
        } else {
            $worker = array_pop($this->free_collection);
        }

        $this->occupied_collection[$worker->getId()] = $worker;

        return $worker;
        */
    }

    /**
     * Release a occupied module into free listing
     *
     * @param Module $worker
     */
    public function release(Module $worker)
    {
        $id = $worker->getId();

        if (isset($this->occupied_collection[$id])) {
            unset($this->occupied_collection[$id]);

            $this->free_collection[$id] = $worker;
        }
    }

    /**
     * Invoke a specific method in Module if the method exists
     *
     * @param $method
     */
    public function callMethod($method)
    {
        // iterate through elements
        foreach ($this->collection as $module) {
            $module($method);
        }
    }
}