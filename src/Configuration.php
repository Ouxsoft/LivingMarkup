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

    public $config;
    private $root_dir;

    /**
     * Configuration constructor.
     * @param string $filename
     */
    public function __construct(string $filename = null)
    {
        // only allow files that exist within file root directory, one level up
        $this->root_dir = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR;

        $this->load($filename);
    }

    /**
     * Load YAML Config file
     * @param string $filename
     * @return bool|mixed
     */
    public function load(string $filename = null)
    {
        $validator = new Exists($this->root_dir);

        // try to load config using filename
        try {
            if (($filename !== null) && ($validator->isValid($filename))) {
                $this->config = $this->parse($filename);
                return true;
            }
        } catch (\Exception $e) {
            // ignore missing file exception
        }

        // try to load local config
        try {
            $path = self::LOCAL_FILENAME;
            if ($validator->isValid($path)) {
                $this->config = $this->parse($path);
                return true;
            }
        } catch (\Exception $e) {
            // ignore missing file exception
        }

        // try to load dist config
        try {
            $path = self::DIST_FILENAME;
            if ($validator->isValid($path)) {
                $this->config = $this->parse($path);
                return true;
            }
        } catch (\Exception $e) {
            // ignore missing file exception
        }

        return false;
    }

    /**
     * Parse YAML config file
     * @param $path
     * @return bool|mixed
     */
    private function parse($path)
    {
        $reader = new Yaml();
        $config = $reader->fromFile($this->root_dir . $path);

        if (empty($config)) {
            return false;
        }

        return $config;
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
     * Temporarily adds runtime globals to config and returns config
     * @return mixed
     */
    public function get(): array
    {
        return $this->config;
    }

    /**
     * Get array of modules if in config
     * @return bool
     */
    public function getModules()
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
        $last_checked = $this->config;
        foreach ($keys as $key) {
            if (!array_key_exists($key, $last_checked)) {
                return false;
            }
            $last_checked = $last_checked[$key];
        }
        return true;
    }

    /**
     * Get array of modules if in config
     * @return bool
     */
    public function getMethods()
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
}
