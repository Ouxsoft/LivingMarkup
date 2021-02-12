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

/**
 * Interface ConfigurationInterface
 * @package Ouxsoft\LivingMarkup\Contract
 */
interface ConfigurationInterface
{
    /**
     * ConfigurationInterface constructor.
     * @param DocumentInterface $document
     * @param string|null $config_file_path
     */
    public function __construct(
        DocumentInterface &$document,
        ?string $config_file_path = null
    );

    /**
     * @param string|null $filepath
     */
    public function loadFile(string $filepath = null): void;

    public function clearConfig(): void;

    /**
     * @param array $config
     */
    public function setConfig(array $config): void;

    /**
     * @param string $markup
     */
    public function setMarkup(string $markup): void;

    /**
     * @param array $element
     */
    public function addElement(array $element): void;

    /**
     * @param array $elements
     */
    public function addElements(array $elements): void;

    /**
     * @return array
     */
    public function getElements(): array;

    /**
     * @param array $routine
     */
    public function addRoutine(array $routine): void;

    /**
     * @param array $routines
     */
    public function addRoutines(array $routines): void;

    /**
     * @return array
     */
    public function getRoutines(): array;

    /**
     * @return string
     */
    public function getMarkup(): string;
}
