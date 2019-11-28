<?php

namespace Pxp\Page\Builder;

abstract class Builder
{
    abstract function createObject($parameters) : ?bool;
    abstract function getObject() : ?object;
}