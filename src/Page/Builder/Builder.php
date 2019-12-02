<?php

namespace Pxp\Page\Builder;

/**
 * Class Builder
 * @package Pxp\Page\Builder
 */
abstract class Builder
{
    /**
     * Creates object using parameters supplied
     *
     * @param $parameters
     * @return bool|null
     */
    abstract function createObject(array $parameters) : ?bool;

    /**
     * Returns object
     *
     * @return object|null
     */
    abstract function getObject() : ?object;
}