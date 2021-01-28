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

    public $routines = [];
    public $elements = [];
    public $markup = '';

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
                $json = $reader->fromFile($path);

                if (is_array($json)) {
                    break;
                }
            } catch (Throwable $e) {
                throw new Exception('Unable to load config' . $e);
            }
        }

        // set and check config file values
        foreach($json as $key => $value){
            switch($key){
                case 'routines':
                    $this->routines = $value;
                    break;
                case 'elements':
                    $this->elements = $value;
                    break;
                case 'version':
                    if($value != self::VERSION){
                        throw new Exception('Unsupported config version');
                    }
                    break;
            }
        }

    }

    /**
     * Set LHTML source/markup
     *
     * @param string $markup
     */
    public function setMarkup(string $markup): void
    {
        $this->markup = $markup;
        $this->document->loadSource($markup);
    }

    /**
     * Adds elements to config
     *
     * @param array $element
     */
    public function addElement(array $element): void
    {
        $this->elements[] = $element;
    }

    /**
     * Adds elements to config
     *
     * @param array $elements
     */
    public function addElements(array $elements): void
    {
        $this->elements = array_merge(
            $elements,
            $this->elements
        );
    }

    /**
     * Get array of elements if in config
     *
     * @return array
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    /**
     * Add routine
     *
     * @param string $method
     * @param string $description
     * @param string|null $execute
     */
    public function addRoutine(string $method, string $description = '', $execute = null): void
    {
        if (is_string($execute)) {
            $this->routines[] = [
                'method' => $method,
                'description' => $description,
                'execute' => $execute
            ];
            return;
        }

        $this->routines[] = [
            'method' => $method,
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
        return $this->routines;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getMarkup(): string
    {
        return $this->markup;
    }
}
