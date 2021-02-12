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

interface EngineInterface
{
    public function __construct(
        DocumentInterface &$document,
        ElementPoolInterface &$element_pool
    );

    public function callRoutine(array $routine): bool;

    public function getElementAncestorProperties(string $element_id): array;

    public function getDomElementByPlaceholderId(string $element_id): ?DOMElement;

    public function queryFetch(string $query, DOMElement $node = null): ?DOMElement;

    public function queryFetchAll(string $query, DOMElement $node = null): ?DOMNodeList;

    public function renderElement(string $element_id): bool;

    public function getElementInnerXML(string $element_id): string;

    public function replaceDomElement(DOMElement $element, string $new_xml): void;

    public function removeElements(array $lhtml_element): void;

    public function instantiateElements(array $lhtml_element): bool;

    public function getElementArgs(DOMElement $element): ArgumentArray;

    public function setType($value = null, $type = 'string');

    public function __toString(): string;
}