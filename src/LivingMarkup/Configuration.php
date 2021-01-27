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

use Laminas\Config\Reader\Json;
use Laminas\Validator\File\Exists;
use LivingMarkup\Contract\ConfigurationInterface;
use LivingMarkup\Contract\DocumentInterface;
use LivingMarkup\Exception\Exception;
use Throwable;

/**
 * Class Configuration
 *
 * Contains a list of Elements, Routines, and the raw HTML/XML document source
 *
 * @package LivingMarkup
 */
class Configuration implements ConfigurationInterface
{
    const LOCAL_FILENAME = 'config.json';
    const DIST_FILENAME = 'config.dist.json';
    const VERSION = 3;

    private $document;
    private $properties;

    /**
     * Configuration constructor.
     * @param DocumentInterface $document
     * @param string|null $config_file_path
     */
    public function __construct(
        DocumentInterface &$document,
        ?string $config_file_path = null
    )
    {
        $this->document = &$document;

        $this->properties = [
            'version' => self::VERSION,
            'elements' => [],
            'routines' => [],
            'markup' => ''
        ];

        if ($config_file_path !== null) {
            $this->loadFile($config_file_path);
        }
    }

    /**
     * Configuration constructor.
     *
     * @param string|null $filepath
     * @return void
     */
    public function loadFile(string $filepath = null): void
    {
        // fail overs for distributed configs
        $fail_overs = [
            $filepath,
            self::LOCAL_FILENAME,
            self::DIST_FILENAME
        ];

        foreach ($fail_overs as $filepath) {
            try {
                $path = $filepath;
                $directory = dirname($filepath);
                $filename = basename($filepath);

                // check if path is valid
                $validator = new Exists($directory);
                $validator->isValid($filename);

                // load json file
                $reader = new Json();
                $this->properties = $reader->fromFile($path);

                if (is_array($this->properties)) {
                    break;
                }
            } catch (Throwable $e) {
                throw new Exception('Unable to load config' . $e);
            }
        }
    }

    /**
     * @param $property
     * @return mixed
     */
    public function __get($property){

        switch ($property) {
            case 'version':
                return $this->properties['version'];
            case 'elements':
                return $this->properties['elements'];
            case 'routines':
                return $this->properties['routines'];
            case 'markup':
                return $this->getMarkup();
            default:
                return $this->properties[$property];
        }
    }

    /**
     * @param $property
     * @param $value
     */
    function __set($property, $value) : void {
        switch ($property) {
            case 'version':
                $this->properties['version'] = $value;
                break;
            case 'elements':
                $this->properties['elements'] = $value;
                break;
            case 'routines':
                $this->properties['routines'] = $value;
                break;
            case 'markup':
                $this->setMarkup($value);
                break;
            default:
                $this->properties[$property] = $value;
                break;
        }
    }

    /**
     * Set LHTML source/markup
     *
     * @param string $markup
     */
    public function setMarkup(string $markup): void
    {
        $this->properties['markup'] = $markup;
        $this->document->loadSource($markup);
    }

    /**
     * Adds elements to config
     *
     * @param array $element
     */
    public function addElement(array $element): void
    {
        $this->properties['elements'][] = $element;
    }

    /**
     * Adds elements to config
     *
     * @param array $elements
     */
    public function addElements(array $elements): void
    {
        if (!isset($this->properties)
            || array_key_exists('elements', $this->properties)
        ) {
            $this->properties['elements'] = array_merge(
                $elements,
                $this->properties['elements']
            );
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
        if (!isset($this->properties)
            || !array_key_exists('elements', $this->properties)
        ) {
            return [];
        }

        return $this->properties['elements'];
    }

    /**
     * Checks if keys are set
     *
     *
     * @param string ...$keys
     * @return bool
     */
    public function isset(string ...$keys): bool
    {
        $last_checked = $this->properties;

        foreach ($keys as $key) {
            if (!array_key_exists($key, $last_checked)) {
                return false;
            }
            $last_checked = $last_checked[$key];
        }
        return true;
    }

    /**
     * Add routine
     *
     * @param string $routine_name
     * @param string $description
     * @param string|null $execute
     */
    public function addRoutine(string $routine_name, string $description = '', $execute = null): void
    {
        if (is_string($execute)) {
            $this->properties['routines'][] = [
                'name' => $routine_name,
                'description' => $description,
                'execute' => $execute
            ];
            return;
        }

        $this->properties['routines'][] = [
            'name' => $routine_name,
            'description' => $description,
        ];
    }

    /**
     * Get array of elements if in config
     *
     * @return array
     */
    public function getRoutines(): array
    {
        if (!isset($this->properties)
            || !array_key_exists('routines', $this->properties)
        ) {
            return [];
        }

        return $this->properties['routines'];
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getMarkup(): string
    {
        // check if exists
        if (!isset($this->properties)
            || !array_key_exists('markup', $this->properties)
        ) {
            return '';
        }

        return $this->properties['markup'];
    }
}
