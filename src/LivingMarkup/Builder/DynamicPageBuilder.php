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
     * @param Configuration $config
     * @return void
     */
    public function createObject(Configuration $config): void
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
    }

    /**
     * Gets Page object
     * @return Engine
     */
    public function getObject(): Engine
    {
        return $this->engine;
    }
}
