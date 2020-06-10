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

namespace LivingMarkup;

use LivingMarkup\Builder\BuilderInterface;

/**
 * Class PageKernelTest
 * @package LivingMarkup\Page
 */
class Kernel
{
    /**
     * Calls Builder using parameters supplied
     * @param BuilderInterface $builder
     * @param $config
     * @return Engine
     */
    public function build(BuilderInterface &$builder, Configuration $config): Engine
    {
        $builder->createObject($config);

        return $builder->getObject();
    }
}
