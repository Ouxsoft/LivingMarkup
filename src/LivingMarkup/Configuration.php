<?php

/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup;

use Exception;
use Laminas\Config\Reader\Yaml;
use Laminas\Validator\File\Exists;

/**
 * Class Configuration
 * @package LivingMarkup
 */
class Configuration
{
    const LOCAL_FILENAME = 'config.yml';
    const DIST_FILENAME = 'config.dist.yml';

    public $config = [
        'version' => 1,
        'modules' => [
            'types' => [],
            'methods' => []
        ]
    ];
    private $path; // full path to config file
    private $directory; // directory config file is in
    private $filename; // base name of file

    /**
     * Configuration constructor.
     * @param string|null $path
     * @return bool
     */
    public function loadFile(string $path = null)
    {
        $this->setPath($path);
        $this->setDirectory($path);
        $this->setFilename($path);

        // load filename, if provided
        if ($this->load($path)) {
            return true;
        }

        // load local config, if exists
        if ($this->load(self::LOCAL_FILENAME)) {
            return true;
        }

        // load dist file, if exists
        if ($this->load(self::DIST_FILENAME)) {
            return true;
        }
        return false;
    }

    /**
     * Load YAML Config file
     * @return bool|mixed
     */
    public function load()
    {

        // check if filename provided
        if ($this->filename === null) {
            return false;
        }

        // try to load config using filename
        try {
            // check if path is valid
            $validator = new Exists($this->directory);
            if (! $validator->isValid($this->filename)) {
                return false;
            }

            $this->config = $this->parse();
            return true;
        } catch (Exception $e) {
            trigger_error('Unable to load config' . $e, E_USER_ERROR);
            return false;
        }

        return false;
    }

    /**
     * Parse YAML config file
     * @return bool|mixed
     */
    private function parse()
    {
        $reader = new Yaml();
        $config = $reader->fromFile($this->path);

        if (empty($config)) {
            return false;
        }

        return $config;
    }

    /**
     * Set filename of config file
     * @param $path
     */
    public function setFilename($path)
    {
        $this->filename = basename($path);
    }


    /**
     * Set directory where configs are stored
     * @param $path
     */
    public function setDirectory($path)
    {
        $this->directory = dirname($path);
    }

    /**
     * Set path to config file
     * @param $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function add(string $key, $value): bool
    {
        $this->config[$key] = $value;

        return true;
    }


    /**
     * Adds modules to config
     * @param array $module
     */
    public function addModule(array $module)
    {
        $this->config['modules']['types'][] = $module;
    }

    /**
     * Adds modules to config
     * @param array $modules
     */
    public function addModules(array $modules)
    {
        if (
            array_key_exists('modules', $this->config) &&
            array_key_exists('types', $this->config['modules'])
        ) {
            $this->config['modules']['types'] = array_merge($modules, $this->config['modules']['types']);
        }
    }

    /**
     * Get array of modules if in config
     * @return array
     */
    public function getModules(): array
    {
        // check if exists
        if (!$this->isset('modules', 'types')) {
            return [];
        }

        return $this->config['modules']['types'];
    }

    /**
     * Recursive key check
     * @param array $keys
     * @return bool
     */
    public function isset(...$keys): bool
    {
        $last_checked = $this->get();
        if (is_null($last_checked)) {
            return false;
        }
        foreach ($keys as $key) {
            if (!array_key_exists($key, $last_checked)) {
                return false;
            }
            $last_checked = $last_checked[$key];
        }
        return true;
    }

    /**
     * Temporarily adds runtime globals to config and returns config
     * @return mixed
     */
    public function get(): array
    {
        return $this->config;
    }

    /**
     * Add method
     *
     * @param string $method_name
     * @param string $description
     * @param string $execute
     */
    public function addMethod(string $method_name, string $description = '', $execute = null){

        if(is_string($execute)){
            $this->config['modules']['methods'][] = [
                'name' => $method_name,
                'description' => $description,
                'execute' => $execute
            ];
            return;
        }

        $this->config['modules']['methods'][] = [
            'name' => $method_name,
            'description' => $description,
        ];
    }

    /**
     * Get array of modules if in config
     * @return array
     */
    public function getMethods(): array
    {
        // check if exists
        if (!$this->isset('modules', 'methods')) {
            return [];
        }

        return $this->config['modules']['methods'];
    }

    /**
     * Get source
     * @return string
     */
    public function getSource(): string
    {
        if (array_key_exists('filename', $this->config)) {
            return file_get_contents($this->config['filename']);
        } elseif (array_key_exists('markup', $this->config)) {
            return $this->config['markup'];
        } else {
            return '';
        }
    }

    public function setMarkup(string $markup){
        $this->config['markup'] = $markup;
    }
}
