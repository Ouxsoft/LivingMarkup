<?php

namespace Ouxsoft\LivingMarkup\Contract;

use Ouxsoft\LivingMarkup\Element\AbstractElement;
use ArrayIterator;

interface ElementPoolInterface
{
    public function count(): int;

    public function getIterator(): ArrayIterator;

    public function getById(?string $element_id = null): ?AbstractElement;

    public function getPropertiesById(string $element_id): array;

    public function add(AbstractElement &$element): void;

    public function callRoutine(string $routine): void;
}
