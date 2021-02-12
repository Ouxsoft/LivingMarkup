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

interface ConfigurationInterface
{
    public function __construct(
        DocumentInterface &$document,
        ?string $config_file_path = null
    );

    public function loadFile(string $filepath = null): void;

    public function clearConfig(): void;

    public function setConfig(array $config): void;

    public function setMarkup(string $markup): void;

    public function addElement(array $element): void;

    public function addElements(array $elements): void;

    public function getElements(): array;

    public function addRoutine(array $routine): void;

    public function addRoutines(array $routines): void;

    public function getRoutines(): array;

    public function getMarkup(): string;
}