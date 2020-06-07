<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Builder;

use LivingMarkup\Configuration;
use LivingMarkup\Engine;

/**
 * Class StaticPageBuilder
 * @package LivingMarkup\Page\Builder
 */
class StaticPageBuilder implements BuilderInterface
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
