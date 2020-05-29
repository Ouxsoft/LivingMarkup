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

use LivingMarkup\Configuration;
use LivingMarkup\Engine;

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
     * @param Configuration $config
     * @return bool|null
     */
    public function createObject(Configuration $config): ?bool
    {

        // create engine pass source
        $this->engine = new Engine($config);

        // instantiate modules
        foreach ($config->getModules() as $module) {
            $this->engine->instantiateModules($module);
        }

        // call module method
        foreach ($config->getMethods() as $method) {
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
