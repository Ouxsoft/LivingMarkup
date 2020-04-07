<?php

namespace LivingMarkup;

use Laminas\Validator\File\Exists;

/**
 * Class ImageResize
 * checks if the requested image exists in cache using a hash
 * if it is not cached, it checks to see if the image exists as an assets
 * if the image exists, than it generates a resized image and stores it in cache
 * and then serves that image
 *
 * @package LivingMarkup
 */
class ImageResize
{
    const JPEG = 1;
    const JPG = 1;
    const PNG = 2;

    private $root_dir;

    private $filename;
    private $width;
    private $height;
    private $focal_point_x;
    private $focal_point_y;
    private $image;
    private $image_original;
    private $cache_dir;
    private $cache_filename;
    private $cache_filepath;
    private $assets_dir;

    /**
     * ImageResize constructor.
     * @param $relative_path
     */
    public function __construct(string $relative_path = null){
        // declare directories
        $this->root_dir = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR;
        $this->assets_dir = $this->root_dir . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
        $this->cache_dir = $this->root_dir . 'var' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;

        $this->setFilename($relative_path);
    }

    /**
     * @param $filename
     * @return bool
     */
    public function setFilename(string $filename) : bool{
        if($filename == null){
            return false;
        }

        $this->filename = $filename;

        // set cache hash of file name, seems wiser than hash_file()
        $this->cache_filename = hash('sha256', $filename);
        $this->cache_filepath = $this->cache_dir . $this->cache_filename;

        return true;
    }

    /**
     * Get cached file
     */
    public function outputCache(){

        try {
            // check if cache exists
            $cache_validator = new Exists($this->cache_dir);
            if ($cache_validator->isValid($this->cache_filename)) {
                // return cached image
                header('Content-Type: image/jpeg');
                echo file_get_contents($this->cache_filepath, false);
                die();
            }
        } catch (Exception $exception) {
            return false;
        }

    }

    public function output(){

        // if cache exist, then output instead
        $this->outputCache();

        // assets
        $assets_filename = $this->filename;
        $assets_filepath = $this->assets_dir . $assets_filename;
        $assets_validator = new Exists($this->assets_dir);

// if asset cache and provide
//if ($assets_validator->isValid($assets_filename)) {
        // get width and height
        list($width_original, $height_original) = getimagesize($assets_filepath);

        // determine original ratio
        $ratio_original = $width_original / $height_original;

        if ($this->width / $this->height > $ratio_original) {
            $this->width = $this->height * $ratio_original;
        } else {
            $this->height = $this->width / $ratio_original;
        }

        $image_output = imagecreatetruecolor($this->width, $this->height);
        $image_original = imagecreatefromjpeg($assets_filepath);
        imagecopyresampled($image_output,
            $image_original,
            0,
            0,
            0,
            0,
            $this->width,
            $this->height,
            $width_original,
            $height_original);

        // write file to cache
        imagejpeg($image_output, $this->cache_filepath, 100);

        // output
        header('Content-Type: image/jpeg');
        imagejpeg($image_output, null, 100);
    }

    /**
     * Sets Focal Point X
     * @param mixed $focal_point_x
     */
    public function setFocalPointX($focal_point_x): void
    {
        $this->focal_point_x = $focal_point_x;
    }

    /**
     * Sets Focal Point Y
     * @param $focal_point_y
     */
    public function setFocalPointY($focal_point_y): void
    {
        $this->focal_point_y = $focal_point_y;
    }

    /**
     * Sets Focal Point X & Y
     * @param $focal_point_x
     * @param $focal_point_y
     */
    public function setFocalPoints($focal_point_x, $focal_point_y)
    {
        $this->focal_point_x = $focal_point_x;
        $this->focal_point_y = $focal_point_y;
    }

    /**
     * Sets height
     * @param $height
     */
    public function setHeight($height)
    {
        $this->height=$height;
    }

    /**
     * Sets width
     * @param $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * Sets both height and width
     * @param $height
     * @param $width
     */
    public function setDimensions($height, $width)
    {
        $this->height = $height;
        $this->width = $width;
    }

    /**
     * Saves $this->image to specific path
     * @param $filename
     */
    public function save($filename)
    {
    }

    /**
     * Loads image for resizing
     * @param $filename
     */
    public function load($filename)
    {
    }

    /**
     * Crops image
     * @param null $height
     * @param null $width
     * @param null $focal_point_x
     * @param null $focal_point_y
     */
    public function crop($height = null, $width = null, $focal_point_x = null, $focal_point_y = null)
    {
        if ($height!==null) {
            $this->height = $height;
        }

        if ($width!==null) {
            $this->width = $width;
        }

        if ($focal_point_x!==null) {
            $this->focal_point_x = $focal_point_x;
        }

        if ($focal_point_y!==null) {
            $this->focal_point_x = $focal_point_y;
        }
    }

    /**
     * Return image object
     * @return mixed
     */
    public function get()
    {
        return $this->image;
    }
}
