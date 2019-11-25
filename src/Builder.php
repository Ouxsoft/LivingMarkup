<?php

namespace Pxp;

abstract class Builder
{
    abstract function createObject($parameters) : ?bool;
    abstract function getObject() : ?object;
}