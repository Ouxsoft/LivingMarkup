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
 * Class PageKernelTest
 * @package LivingMarkup\Page
 */
class Kernel
{
    /**
     * Calls Builder using parameters supplied
     *
     * @param Builder\BuilderInterface $builder
     * @param $config
     * @return object
     */
    public function build(Builder\BuilderInterface &$builder, $config): object
    {
        $builder->createObject($config);

        return $builder->getObject();
    }
}
