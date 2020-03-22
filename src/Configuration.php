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

use Symfony\Component\Yaml\Yaml;

/**
 * Class Configuration
 * @package LivingMarkup
 */
class Configuration
{
    const LOCAL_FILENAME = 'config.yml';
    const DIST_FILENAME = 'config.dist.yml';

    public $config;

    /**
     * Configuration constructor.
     * @param string $filename
     */
    public function __construct(string $filename = NULL)
    {
        $this->load($filename);
    }

    /**
     * Load YAML Config file
     * @param string $filename
     * @return bool|mixed
     */
    public function load(string $filename = NULL)
    {

        // try to load config using filename if parameter set
        if (($filename !== NULL) && (file_exists($filename))) {
            $this->config = $this->parse($filename);
            return true;
        }

        // try to load local config
        $path = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . self::LOCAL_FILENAME;
        if (file_exists($path)) {
            $this->config = $this->parse($path);
            return true;
        }

        // try to load dist config
        $path =  dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . self::DIST_FILENAME;
        if (file_exists($path)) {
            $this->config = $this->parse($path);
            return true;
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
        $config = Yaml::parseFile($path);

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