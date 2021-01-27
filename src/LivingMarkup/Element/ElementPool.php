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

namespace LivingMarkup\Element;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use LivingMarkup\Contract\ElementPoolInterface;
use Traversable;

/**
 * Class ElementPool
 *
 * Stores and retrieves individual elements
 *
 * @package LivingMarkup
 */
class ElementPool implements
    Countable,
    IteratorAggregate,
    ElementPoolInterface
{
    public $collection = [];

    /**
     * Returns a count of number of elements in collection
     * @return int
     */
    public function count(): int
    {
        return count($this->collection);
    }

    /**
     * Iterator to go through element pool
     *
     * @return ArrayIterator|Traversable
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->collection);
    }

    /**
     * Get Element by placeholder id
     * @param string|null $element_id
     * @return AbstractElement|null
     */
    public function getById(?string $element_id = null): ?AbstractElement
    {
        if (array_key_exists($element_id, $this->collection)) {
            return $this->collection[$element_id];
        }

        return null;
    }

    /**
     * Get the public properties of a element using the elements ID
     *
     * @param string $element_id
     * @return array
     */
    public function getPropertiesById(string $element_id): array
    {
        return get_object_vars($this->collection[$element_id]);
    }

    /**
     * Add new element to pool
     *
     * @param $element
     */
    public function add(AbstractElement &$element): void
    {
        $this->collection[$element->element_id] = &$element;
    }

    /**
     * Invoke a method if present in each element
     *
     * @param $routine
     */
    public function callRoutine(string $routine): void
    {
        // iterate through elements
        foreach ($this->collection as $element) {
            $element($routine);
        }
    }
}
