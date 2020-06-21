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
 * Class SearchIndexBuilder
 *
 * @package LivingMarkup\Builder
 */
class SearchIndexBuilder implements BuilderInterface
{
    public $engine;

    /**
     * Creates Page object using parameters supplied
     *
     * @param Configuration $config
     * @return void
     */
    public function createObject(Configuration $config): void
    {

        // create engine pass source
        $this->engine = new Engine($config);

        // instantiate elements
        foreach ($config->getElements() as $element) {
            $this->engine->instantiateElements($element);
        }

        // call element method
        foreach ($config->getMethods() as $method) {
            $this->engine->callMethod($method);
        }
    }

    /**
     * Gets Page object
     *
     * @return Engine
     */
    public function getObject(): Engine
    {
        return $this->engine;
    }
}
