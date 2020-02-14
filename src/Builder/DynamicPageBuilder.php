<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Builder;

use LivingMarkup\Engine as Engine;

/**
 * Class DynamicPageBuilder
 * @package LivingMarkup\Page\Builder
 */
class DynamicPageBuilder implements BuilderInterface
{
    public $engine;

    /**
     * Creates Page object using parameters supplied
     *
     * @param $config
     * @return bool|null
     */
    public function createObject(array $config): ?bool
    {
        // set source
        if (array_key_exists('filename', $config)) {
            $source = file_get_contents($config['filename']);
        } elseif (array_key_exists('markup', $config)) {
            $source = $config['markup'];
        } else {
            $source = '';
        }

        // create engine pass source
        $this->engine = new Engine($source);

        // return if no components
        if (!array_key_exists('components', $config)){
            return true;
        }

        // return if no components types
        if (!array_key_exists('types', $config['components'])){
            return true;
        }

        // instantiate components
        foreach($config['components']['types'] as $component){
            $this->engine->instantiateComponents($component['xpath'], $component['class_name']);
        }

        // return if no component methods
        if (!array_key_exists('methods', $config['components'])){
            return true;
        }

        // call component method
        foreach($config['components']['methods'] as $method){
            $this->engine->callHook($method);
        }

        return true;
    }

    /**
     * Gets Page object
     *
     * @return object|null
     */
    public function getObject(): ?object
    {
        return $this->engine;
    }
}
