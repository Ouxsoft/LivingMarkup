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
 * Class PageDirectorTest
 * @package LivingMarkup\Page
 */
class Director
{
    /**
     * Calls Builder using parameters supplied
     *
     * @param Builder\BuilderInterface $builder
     * @param $parameters
     * @return object
     */
    public function build(Builder\BuilderInterface &$builder, $parameters): object
    {
        $builder->createObject($parameters);

        return $builder->getObject();
    }
}
