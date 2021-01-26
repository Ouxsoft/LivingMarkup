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

use LivingMarkup\Contract\ConfigurationInterface;
use LivingMarkup\Contract\EngineInterface;
use LivingMarkup\Engine;

/**
 * Class SearchIndexBuilder
 *
 * @package LivingMarkup\Builder
 */
class SearchIndexBuilder implements BuilderInterface
{

    private $engine;
    private $config;

    public function __construct(EngineInterface &$engine, ConfigurationInterface &$config)
    {
        $this->engine = &$engine;
        $this->config = &$config;
    }

    /**
     * Creates Page object using parameters supplied
     *
     * @return void
     */
    public function createObject(): void
    {
        // instantiate elements
        foreach ($this->config->getElements() as $element) {
            $this->engine->instantiateElements($element);
        }

        // call element method
        foreach ($this->config->getMethods() as $method) {
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
