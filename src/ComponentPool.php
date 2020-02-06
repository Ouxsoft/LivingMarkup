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
 * Initializes and gets components
 *
 * @package LivingMarkup
 */
class ComponentPool
{
    // TODO: Class is not yet implemented

    private $occupied_components = [];
    private $free_components = [];

    public function get(?string $placeholder_id = null)
    {
    }

    /**
     * Get Component by placeholder id
     *
     * @param string $component_id
     * @return object
     */
    public function getById(string $component_id)
    {
        // TODO: Mark as occupied
        if (array_key_exists($component_id, $this->free_components)) {
            return $this->free_components[$component_id];
        }

        return null;
    }
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
}

/*
properties
render
innerXML
invokeMethod
instantiate
*/
