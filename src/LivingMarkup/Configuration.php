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

namespace LivingMarkup;

use Laminas\Exception\RuntimeException;
use LivingMarkup\Exception\Exception;
use Laminas\Config\Reader\Yaml;
use Laminas\Validator\File\Exists;

/**
 * Class Configuration
 *
 * @package LivingMarkup
 */
class Configuration
{
    const LOCAL_FILENAME = 'config.yml';
    const DIST_FILENAME = 'config.dist.yml';

    public $container = [
        'version' => 1,
        'elements' => [
            'types' => [],
            'methods' => []
        ]
    ];
    private $path; // full path to config file
    private $directory; // directory config file is in
    private $filename; // base name of file

    /**
     * Configuration constructor.
     *
     * @param string|null $filepath
     * @return void
     */
    public function loadFile(string $filepath = null) : void
    {
        // fail overs for distributed configs
        $fail_overs = [$filepath, self::LOCAL_FILENAME, self::DIST_FILENAME];

        foreach ($fail_overs as $filepath) {
            try {
                $this->path = $filepath;
                $this->directory = dirname($filepath);
                $this->filename = basename($filepath);

                // check if path is valid
                $validator = new Exists($this->directory);
                $validator->isValid($this->filename);

                // load yaml file
                $reader = new Yaml();
                $this->container = $reader->fromFile($this->path);

                if (is_array($this->container)) {
                    break;
                }
            } catch (\Throwable $e) {
                throw new Exception('Unable to load config');
            }
        }
    }

    /**
     * Add item to config
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function add(string $key, $value): bool
    {
        $this->container[$key] = $value;

        return true;
    }

    /**
     * Adds elements to config
     *
     * @param array $element
     */
    public function addElement(array $element) : void
    {
        $this->container['elements']['types'][] = $element;
    }

    /**
     * Adds elements to config
     *
     * @param array $elements
     */
    public function addElements(array $elements) : void
    {
        if (
            array_key_exists('elements', $this->container) &&
            array_key_exists('types', $this->container['elements'])
        ) {
            $this->container['elements']['types'] = array_merge($elements, $this->container['elements']['types']);
        }
    }

    /**
     * Get array of elements if in config
     *
     * @return array
     */
    public function getElements(): array
    {
        // check if exists
        if (!isset($this->container)
            || !isset($this->container['elements'])
            || !is_array($this->container['elements'])
            || !array_key_exists('types', $this->container['elements'])
        ) {
            return [];
        }

        return $this->container['elements']['types'];
    }

    /**
     * Recursive key check
     *
     * @param array $keys
     * @return bool
     */
    public function isset(...$keys): bool
    {
        if (!isset($this->container)) {
            return false;
        }

        $last_checked = $this->container;

        foreach ($keys as $key) {
            if (!array_key_exists($key, $last_checked)) {
                return false;
            }
            $last_checked = $last_checked[$key];
        }
        return true;
    }

    /**
     * Add method
     *
     * @param string $method_name
     * @param string $description
     * @param string $execute
     */
    public function addMethod(string $method_name, string $description = '', $execute = null) : void
    {
        if (is_string($execute)) {
            $this->container['elements']['methods'][] = [
                'name' => $method_name,
                'description' => $description,
                'execute' => $execute
            ];
            return;
        }

        $this->container['elements']['methods'][] = [
            'name' => $method_name,
            'description' => $description,
        ];
    }

    /**
     * Get array of elements if in config
     *
     * @return array
     */
    public function getMethods(): array
    {
        // check if exists
        if (!isset($this->container)
            || !isset($this->container['elements'])
            || !is_array($this->container['elements'])
            || !array_key_exists('methods', $this->container['elements'])
        ) {
            return [];
        }


        return $this->container['elements']['methods'];
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource(): string
    {
        // check if exists
        if (!isset($this->container)
            || !array_key_exists('markup', $this->container)
        ) {
            return '';
        }

        return $this->container['markup'];
    }

    /**
     * Set LHTML source/markup
     *
     * @param string $markup
     */
    public function setSource(string $markup) : void
    {
        $this->container['markup'] = $markup;
    }
}
