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

        // return if no modules
        if (!array_key_exists('modules', $config)) {
            return true;
        }

        // return if no modules types
        if (!array_key_exists('types', $config['modules'])) {
            return true;
        }

        // instantiate modules
        foreach ($config['modules']['types'] as $module) {
            $this->engine->instantiateModules($module);
        }

        // return if no module methods
        if (!array_key_exists('methods', $config['modules'])) {
            return true;
        }

        // call module method
        foreach ($config['modules']['methods'] as $method) {
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
