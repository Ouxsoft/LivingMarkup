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
    const VERSION = 3;
    const LOCAL_FILENAME = 'config.json';
    const DIST_FILENAME = 'config.dist.json';

    private $document;

    public $version;
    public $elements = [];
    public $routines = [];
    public $markup = '';

    /**
     * Configuration constructor
     *
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
     * load a configuration file
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

                if (
                    is_array($json)
                    && (count($json) > 0)
                ) {
                    $this->setConfig($json);
                    return;
                }
            } catch (Throwable $e) {
                // do nothing
                throw new Exception('Invalid config file provided');
            }
        }
    }

    /**
     * Clear config
     */
    public function clearConfig(): void
    {
        $this->version = self::VERSION;
        $this->elements = [];
        $this->routines = [];
        $this->markup = '';
    }

    /**
     * Set entire config at once
     *
     * @param array $config
     */
    public function setConfig(array $config): void
    {
        $this->clearConfig();

        foreach($config as $key => $value){
            switch($key){
                case 'version':
                    if($value != self::VERSION){
                        throw new Exception('Unsupported config version');
                    }
                    break;
                case 'elements':
                    $this->addElements($value);
                    break;
                case 'routines':
                    $this->addRoutines($value);
                    break;
                case 'markup':
                    $this->setMarkup();
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
     * Adds a element
     *
     * @param array $element
     */
    public function addElement(array $element): void
    {
        if(!array_key_exists('xpath', $element)){
            throw new Exception('Xpath required for addElements');
        }

        if(!array_key_exists('class_name', $element)){
            throw new Exception('class_name required for addElements');
        }

        if (!in_array($element, $this->elements))
        {
            $this->elements[] = $element;
        }
    }

    /**
     * Adds multiple elements at once
     *
     * @param array $elements
     */
    public function addElements(array $elements): void
    {
        foreach($elements as $element){
            $this->addElement($element);
        }
    }

    /**
     * Get elements
     *
     * @return array
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    /**
     * Adds a routine
     *
     * @param array $routine
     */
    public function addRoutine(array $routine): void
    {
        if(!array_key_exists('method', $routine)){
            throw new Exception('Method required for addRoutines');
        }

        if (!in_array($routine, $this->routines))
        {
            $this->routines[] = $routine;
        }
    }

    /**
     * Adds multiple routines at once
     *
     * @param array $routines
     */
    public function addRoutines(array $routines): void
    {
        foreach($routines as $routine){
            $this->addRoutine($routine);
        }
    }

    /**
     * Get routines
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
