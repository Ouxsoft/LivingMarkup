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

/**
 * Class ModulePool
 *
 * Initializes and retrieves individual modules
 *
 * @package LivingMarkup
 */
class ModulePool
{
    const INDEX_ATTRIBUTE = '_MODULE_ID';

    public $module = [];

    // TODO: implement pool design pattern
    private $occupied_modules = [];
    private $free_modules = [];

    /**
     * Get Module by placeholder id
     *
     * @param string|null $module_id
     * @return object
     */
    public function getById(?string $module_id = null)
    {
        // TODO: Mark as occupied
        if (array_key_exists($module_id, $this->module)) {
            return $this->module[$module_id];
        }

        return null;
    }

    public function add(&$module)
    {
        $this->module[$module->module_id] = $module;
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
        if (count($this->free_modules) == 0) {
            $id = count($this->occupied_modules) + count($this->free_modules) + 1;
            $randomName = array_rand($this->names, 1);

            $worker = new Module($id, $this->names[$randomName]);
        } else {
            $worker = array_pop($this->free_modules);
        }

        $this->occupied_modules[$worker->getId()] = $worker;

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

        if (isset($this->occupied_modules[$id])) {
            unset($this->occupied_modules[$id]);

            $this->free_modules[$id] = $worker;
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
        foreach ($this->module as $module) {
            $module($method);
        }
    }
}
