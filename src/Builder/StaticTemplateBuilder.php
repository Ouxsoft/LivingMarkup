<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Builder;

/**
 * Class StaticTemplateBuilder
 * @package LivingMarkup\Page\Builder
 */
class StaticTemplateBuilder implements BuilderInterface
{
    private $page;

    /**
     * Creates Page object using supplied parameters
     *
     * @param $parameters
     * @return bool|null
     */
    public function createObject(array $parameters): ?bool
    {
        if (!isset($parameters['filename'])) {
            return false;
        }

        // only allow files inside template directory to be loaded
        if (!isTemplateFile($parameters['filename'], $parameters['template_dir'])) {
            return false;
        }

        $this->page = new LivingMarkup\Page\Page($parameters);

        return true;
    }

    /**
     * Returns Page object
     *
     * @return object|null
     */
    public function getObject(): ?object
    {
        return $this->page;
    }

    /**
     * Checks if file is a template file
     *
     * @param string $path
     * @param string $template_dir
     * @return bool
     */
    public function isTemplateFile(string $path = null, string $template_dir = null): bool
    {
        $directory = dirname($path);
        $directory = realpath($directory);
        $folder = substr($path, strlen($directory));
        $folder = preg_replace('/[^a-z0-9\.\-_]/i', '', $folder);

        if ((!$directory) || (!$folder) || ($folder === '.')) {
            return false;
        }

        $path = $directory . DIRECTORY_SEPARATOR . $folder;
        if (strcasecmp($path, $template_dir) > 0) {
            return true;
        }

        return false;
    }
}
