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

use LivingMarkup\Contract\BuilderInterface;
use LivingMarkup\Contract\ConfigurationInterface;
use LivingMarkup\Contract\EngineInterface;
use LivingMarkup\Engine;

/**
 * Class SearchIndexBuilder
 * Builds dynamic pages while removing elements set not to be included in search indexes
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
     * omits elements with search_engine = false
     *
     * @return void
     */
    public function createObject(): void
    {
        // instantiate elements
        foreach ($this->config->getElements() as $element) {
            if(
                array_key_exists('search_index', $element)
                && ($element['search_index'] == false)
            ) {
                $this->engine->removeElements($element);
                continue;
            }
            $this->engine->instantiateElements($element);
        }

        // call element routine
        foreach ($this->config->getRoutines() as $routine) {
            $this->engine->callRoutine($routine);
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
