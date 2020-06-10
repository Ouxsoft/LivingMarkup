<?php

/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
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
     * @param string|null $filepath
     * @return bool
     * @throws Exception
     */
    public function loadFile(string $filepath = null)
    {
        // fail overs for distributed configs
        $fail_overs = [$filepath, self::LOCAL_FILENAME, self::DIST_FILENAME];

        foreach ($fail_overs as $filepath) {
            $this->path = $filepath;
            $this->directory = dirname($filepath);
            $this->filename = basename($filepath);

            // try to load config using filename
            try {
                // check if path is valid
                $validator = new Exists($this->directory);
                if (!$validator->isValid($this->filename)) {
                    return false;
                }

                // load yaml file
                $reader = new Yaml();
                $this->config = $reader->fromFile($this->path);

                if (empty($this->config)) {
                    return false;
                }

                return true;
            } catch (Exception $e) {
                throw new Exception('Unable to load config' . $e);

                return false;
            }

        }

        return false;
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
     * Get the config array
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
    public function addMethod(string $method_name, string $description = '', $execute = null)
    {

        if (is_string($execute)) {
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
        if (array_key_exists('markup', $this->config)) {
            return $this->config['markup'];
        }

        return '';
    }

    /**
     * @param string $markup
     */
    public function setSource(string $markup)
    {
        $this->config['markup'] = $markup;
    }
}
