<?php

namespace Pxp;

abstract class Builder
{
    abstract function createObject() : ?bool;
    abstract function getObject() : ?object;
}