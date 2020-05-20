<?php

namespace LivingMarkup;

use Laminas\Validator\File\Exists;

/**
 * Class Image
 * checks if the requested image exists in cache using a hash
 * if it is not cached, it checks to see if the image exists as an assets
 * if the image exists, than it generates a resized image and stores it in cache
 * and then serves that image
 *
 * @package LivingMarkup
 */
class Image
{
    const JPEG = 1;
    const JPG = 1;
    const PNG = 2;
    const GIF = 3;

    private $root_dir;

    private $filename;
    private $file_extension;
    private $width;
    private $height;
    private $focal_point_x;
    private $focal_point_y;
    private $image;
    private $cache_dir;
    private $cache_filename;
    private $cache_filepath;
    private $assets_dir;

    private $image_original;
    private $height_original;
    private $width_original;
    private $ratio_original;

    /**
     * Image constructor.
     */
    public function __construct()
    {
        // declare directories
        $this->root_dir = dirname(__DIR__, 1) . '/';
        $this->assets_dir = $this->root_dir . 'assets/images/';
        $this->cache_dir = $this->root_dir . 'var/cache/images/';
    }

    /**
     * load by URL
     * @param string|null $request
     * @return bool
     */
    public function loadByURL(string $request = null): bool
    {
        if ($request === null) {
            return false;
        }

        // set cache url
        $this->setCacheURL($request);

        $parameters = Path::Decode($request);

        // set filename
        if (array_key_exists('filename', $parameters)) {
            $filename = substr($parameters['filename'], strlen('/assets/images/'));
            $this->setFilename($filename);
        }

        // set height
        if (array_key_exists('height', $parameters)) {
            $this->setHeight($parameters['height']);
        }

        // set width
        if (array_key_exists('width', $parameters)) {
            $this->setWidth($parameters['width']);
        }

        // set offset x
        if (array_key_exists('offset_x', $parameters)) {
            $this->setFocalPointX($parameters['offset_x']);
        }

        // set offset y
        if (array_key_exists('offset_y', $parameters)) {
            $this->setFocalPointY($parameters['offset_y']);
        }

        return true;
    }

    /**
     * picks the file in assets to use
     * @param $filename
     * @return bool
     */
    public function setFilename(string $filename): bool
    {
        if ($filename == null) {
            return false;
        }

        // set filename
        $this->filename = $filename;

        // set file_extension
        $this->file_extension = strtolower(substr(strrchr($filename, '.'), 1));

        return true;
    }

    /**
     * set cache URL
     * @param string|null $relative_path
     * @return bool
     */
    public function setCacheURL(string $relative_path = null): bool
    {
        if ($relative_path === null) {
            return false;
        }

        // set cache hash of file name
        $this->cache_filename = hash('sha256', $relative_path);
        $this->cache_filepath = $this->cache_dir . $this->cache_filename;

        return true;
    }

    /**
     * Outputs file
     * @return bool
     */
    public function output(): bool
    {
        // if cache exist, then output it
        if ($this->sendCache()) {
            return true;
        }

        // load and resize file
        if (! $this->load() || ! $this->resize()) {
            // if cannot load file send empty
            $this->sendEmpty();
            return false;
        }

        // save cache
        $this->saveCache();

        // send image
        if ($this->sendImage()) {
            return true;
        }

        return false;
    }

    /**
     * Loads image for resizing
     * @return bool
     */
    private function load(): bool
    {
        // assets
        $assets_filename = $this->filename;
        $assets_filepath = $this->assets_dir . $this->filename;
        $assets_validator = new Exists($this->assets_dir);

        if (!$assets_validator->isValid($assets_filename)) {
            //    return false;
        }

        // create image from file
        switch ($this->file_extension) {
            case 'gif':
                $this->image_original = imagecreatefromgif($assets_filepath);
                break;
            case 'png':
                $this->image_original = imagecreatefrompng($assets_filepath);
                break;
            case 'jpeg':
            case 'jpg':
                $this->image_original = imagecreatefromjpeg($assets_filepath);
                break;
            default:
                return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    private function resize()
    {
        // get original width and height
        list($this->width_original, $this->height_original) = getimagesize($this->assets_dir . $this->filename);

        // determine original ratio and desired draw image size
        $this->ratio_original = $this->width_original / $this->height_original;

        // TODO: Algorithum not perfect
        if ( is_numeric($this->width) || is_numeric($this->height) ) {
            // if desired width and height set
            if ( is_numeric($this->width) && is_numeric($this->height) ) {
                if($this->width < $this->height){
                    $draw_image_height = $this->height;
                    $draw_image_width = $this->height * $this->ratio_original;
                } else {
                    $draw_image_height = $this->width / $this->ratio_original;
                    $draw_image_width = $this->width;
                }
            // if width is not set but height is
            } else if ( ! is_numeric($this->width) && is_numeric($this->height) ) {
                $this->width = $this->height * $this->ratio_original;
                $draw_image_width = $this->height * $this->ratio_original;
            // if width is set but height is not set
            } else if ( is_numeric($this->width) && ! is_numeric($this->height) ) {
                $this->height = $this->width * $this->ratio_original;
                $draw_image_height = $this->height * $this->ratio_original;
            }

            // rescale
            if ($draw_image_width < $this->width) {
                $difference = $this->width - $draw_image_width;
                $draw_image_width += $difference;
                $draw_image_height += $difference;
            } elseif ($draw_image_height < $this->height) {
                $difference = $this->height - $draw_image_height;
                $draw_image_width += $difference;
                $draw_image_height += $difference;
            }

            // compute offset
            $max_y = ($draw_image_height - $this->height) / 2;
            $center_y = ($this->height/2) - ($draw_image_height/2);
            $percent_y = ($this->focal_point_y * 2) * 0.01;
            $offset_y = $center_y - ($max_y * $percent_y);

            // compute offset
            $max_x = ($draw_image_width - $this->width) / 2;
            $center_x = ($this->width/2) - ($draw_image_width/2);
            $percent_x = ($this->focal_point_x * 2) * 0.01;
            $offset_x = $center_x - ($max_x * $percent_x);

        } else {
            // no width or height specified, use original file heights
            $this->width = $this->width_original;
            $this->height = $this->height_original;
            $draw_image_height = $this->width_height;
            $draw_image_width = $this->width_original;
            $offset_x = 0;
            $offset_y = 0;
        }

        /*
         * debug
        echo "
        img $this->image,
        img $this->image_original,
        dst_x $offset_x,
        dst_y $offset_y,
        src y 0,
        src x 0,
        dst w $draw_image_width,
        dst h $draw_image_height,
        src w $this->width_original,
        src h $this->height_original";
        die();
        */

        // create image from file
        $this->image = imagecreatetruecolor($this->width, $this->height);
        switch ($this->file_extension) {
            case 'jpg':
            case 'jpeg':
            case 'gif':
                imagecopyresampled(
                    $this->image,
                    $this->image_original,
                    $offset_x,
                    $offset_y,
                    0,
                    0,
                    $draw_image_width,
                    $draw_image_height,
                    $this->width_original,
                    $this->height_original
                );
                break;
            case 'png':
                imagealphablending($this->image, false);
                imagesavealpha($this->image, true);
                imagecopyresampled(
                    $this->image,
                    $this->image_original,
                    $offset_x,
                    $offset_y,
                    0,
                    0,
                    $this->width,
                    $this->height,
                    $this->width_original,
                    $this->height_original
                );
                break;
            default:
                return false;
        }

        return true;
    }

    /**
     * Send empty
     */
    private function sendEmpty()
    {
        header('HTTP/1.0 404 Not Found');
    }

    /**
     * Send $this->image or file, if provided
     * @param null $resource
     * @return bool
     */
    private function sendImage($resource = null): bool
    {
        // send cached image
        if ($resource == $this->cache_filepath) {
            $this->sendCached();
        }

        // send $this->image image
        switch ($this->file_extension) {
            case 'gif':
                header('Content-Type: image/gif');
                imagegif($this->image, null);
                break;
            case 'png':
                header('Content-Type: image/png');
                imagepng($this->image, null, 9);
                break;
            case 'jpeg':
            case 'jpg':
                header('Content-type: image/jpeg');
                imagejpeg($this->image, null, 100);
                break;
            default:
                return false;
        }

        return true;
    }

    /**
     * Send cache of file requested
     * @return bool
     */
    public function sendCache(): bool
    {
        try {
            // check if cache exists
            $cache_validator = new Exists($this->cache_dir);
            if ($cache_validator->isValid($this->cache_filename)) {
                // send cache file
                switch ($this->file_extension) {
                    case 'gif':
                        header('Content-Type: image/gif');
                        header('Content-Length: ' . filesize($this->cache_filepath));
                        readfile($this->cache_filepath);
                        break;
                    case 'png':
                        header('Content-Type: image/png');
                        header('Content-Length: ' . filesize($this->cache_filepath));
                        readfile($this->cache_filepath);
                        break;
                    case 'jpeg':
                    case 'jpg':
                        header('Content-type: image/jpeg');
                        header('Content-Length: ' . filesize($this->cache_filepath));
                        readfile($this->cache_filepath);
                        break;
                    default:
                        return false;
                }

                return true;
            }
        } catch (Exception $exception) {
            // do nothing
        }

        return false;
    }

    /**
     * Saves $this->image to specific path
     */
    private function saveCache()
    {
        // save $this->image to cache
        switch ($this->file_extension) {
            case 'gif':
                imagegif($this->image, $this->cache_filepath);
                break;
            case 'png':
                imagepng($this->image, $this->cache_filepath, 9);
                break;
            case 'jpeg':
            case 'jpg':
                imagejpeg($this->image, $this->cache_filepath, 100);
                break;
            default:
                return false;
        }
    }

    /**
     * Sets Focal Point X
     * @param mixed $focal_point_x
     */
    public function setFocalPointX($focal_point_x): void
    {
        if (! is_numeric($focal_point_x)) {
            $this->focal_point_x = 0;
        } elseif ($focal_point_x > 50) {
            $this->focal_point_x = 50;
        } elseif ($focal_point_x <= -50) {
            $this->focal_point_x = -50;
        } else {
            $this->focal_point_x = $focal_point_x;
        }
    }

    /**
     * Sets Focal Point Y
     * @param $focal_point_y
     */
    public function setFocalPointY($focal_point_y): void
    {
        if (! is_numeric($focal_point_y)) {
            $this->focal_point_y = 0;
        } elseif ($focal_point_y > 50) {
            $this->focal_point_y = 50;
        } elseif ($focal_point_y <= -50) {
            $this->focal_point_y = -50;
        } else {
            $this->focal_point_y = $focal_point_y;
        }
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
        $this->height = $height;
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
     * Crops image
     * @param null $height
     * @param null $width
     * @param null $focal_point_x
     * @param null $focal_point_y
     */
    public function crop($height = null, $width = null, $focal_point_x = null, $focal_point_y = null)
    {
        if ($height !== null) {
            $this->height = $height;
        }

        if ($width !== null) {
            $this->width = $width;
        }

        if ($focal_point_x !== null) {
            $this->focal_point_x = $focal_point_x;
        }

        if ($focal_point_y !== null) {
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
