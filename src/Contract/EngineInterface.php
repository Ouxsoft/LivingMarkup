<?php
/*
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ouxsoft\LivingMarkup\Contract;

use Ouxsoft\LivingMarkup\ArgumentArray;
use DOMElement;
use DOMNodeList;

/**
 * Interface EngineInterface
 * @package Ouxsoft\LivingMarkup\Contract
 */
interface EngineInterface
{
    /**
     * EngineInterface constructor.
     * @param DocumentInterface $document
     * @param ElementPoolInterface $element_pool
     */
    public function __construct(
        DocumentInterface &$document,
        ElementPoolInterface &$element_pool
    );

    /**
     * @param array $routine
     * @return bool
     */
    public function callRoutine(array $routine): bool;

    /**
     * @param string $element_id
     * @return array
     */
    public function getElementAncestorProperties(string $element_id): array;

    /**
     * @param string $element_id
     * @return DOMElement|null
     */
    public function getDomElementByPlaceholderId(string $element_id): ?DOMElement;

    /**
     * @param string $query
     * @param DOMElement|null $node
     * @return DOMElement|null
     */
    public function queryFetch(string $query, DOMElement $node = null): ?DOMElement;

    /**
     * @param string $query
     * @param DOMElement|null $node
     * @return DOMNodeList|null
     */
    public function queryFetchAll(string $query, DOMElement $node = null): ?DOMNodeList;

    /**
     * @param string $element_id
     * @return bool
     */
    public function renderElement(string $element_id): bool;

    /**
     * @param string $element_id
     * @return string
     */
    public function getElementInnerXML(string $element_id): string;

    /**
     * @param DOMElement $element
     * @param string $new_xml
     */
    public function replaceDomElement(DOMElement $element, string $new_xml): void;

    /**
     * @param array $lhtml_element
     */
    public function removeElements(array $lhtml_element): void;

    /**
     * @param array $lhtml_element
     * @return bool
     */
    public function instantiateElements(array $lhtml_element): bool;

    /**
     * @param DOMElement $element
     * @return ArgumentArray
     */
    public function getElementArgs(DOMElement $element): ArgumentArray;

    /**
     * @param null $value
     * @param string $type
     * @return mixed
     */
    public function setType($value = null, $type = 'string');

    /**
     * @return string
     */
    public function __toString(): string;
}
