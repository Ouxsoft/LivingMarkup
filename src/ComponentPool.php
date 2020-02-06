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
 * Class ComponentPool
 *
 * Initializes and retrieves individual components
 *
 * @package LivingMarkup
 */
class ComponentPool
{
    const INDEX_ATTRIBUTE = '_COMPONENT_ID';

    public $component = [];

    // TODO: implement pool design pattern
    private $occupied_components = [];
    private $free_components = [];

    /**
     * Get Component by placeholder id
     *
     * @param string|null $component_id
     * @return object
     */
    public function getById(?string $component_id = null)
    {
        // TODO: Mark as occupied
        if (array_key_exists($component_id, $this->component)) {
            return $this->component[$component_id];
        }

        return null;
    }

    public function add(&$component){
        $this->component[$component->component_id] = $component;
    }

    // TODO in order for worker concept to work the state and data of the object must be separated from the component

    /**
     * Gets a component or initializes a component if one is not present and free
     *
     * @return Component|mixed
     */
    public function getComponent()
    {
        if (count($this->free_components) == 0) {
            $id = count($this->occupied_components) + count($this->free_components) + 1;
            $randomName = array_rand($this->names, 1);

            $worker = new Component($id, $this->names[$randomName]);
        } else {
            $worker = array_pop($this->free_components);
        }

        $this->occupied_components[$worker->getId()] = $worker;

        return $worker;
    }

    /**
     * Release a occupied component into free listing
     *
     * @param Component $worker
     */
    public function release(Component $worker)
    {
        $id = $worker->getId();

        if (isset($this->occupied_components[$id])) {
            unset($this->occupied_components[$id]);

            $this->free_components[$id] = $worker;
        }
    }

    /**
     * Invoke a specific method in Component if the method exists
     *
     * @param $method
     */
    public function callMethod($method){
        // iterate through elements
        foreach ($this->component as $component) {
            $component($method);
        }
    }
}