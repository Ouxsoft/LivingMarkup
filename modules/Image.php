<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Modules;

use LivingMarkup\Path;

class Image extends \LivingMarkup\Module
{
    const IMAGE_DIR = '/assets/images/';

    const IMAGE_CACHE_DIR = '/cache/type/images/';

    public $offset = [
        'x' => 0,
        'y' => 0
    ];

    // decorative
    public $alt = '';
    public $author = 'Unknown';

    public $width = NULL;
    public $height = NULL;

    // original file source
    public $source = 'blank.jpg';

    private $source_width;
    private $source_height;
    private $source_type;
    private $source_attr;

    public function loadSourceInfo()
    {
        // image missing
        if(!isset($this->args['src'])){
            return false;
        }

        list($this->source_width, $this->source_height, $this->source_type, $this->source_attr) = getimagesize($this->args['src']);

        return true;
    }

    // cache/image/{id}/
    public function getInfo($filename)
    {
        // {width}x{height}(+/-){offset_x}(+/-){offset_y}.jpg
        sscanf($filename, "%dx%d%d", $width, $height, $offset_x, $offset_y);
        
        return [
            'width' => $width,
            'height' => $height,
            'offset' => [
                'x' => $offset_x,
                'y' => $offset_y
            ]
        ];
    }

    public function getCacheURL()
    {
        // use base cache directory
        $src = self::IMAGE_CACHE_DIR;
        
        $filename = (empty($this->alt) ? 'decorative' : $this->alt) . '.jpg';
        
        $src .= Path::encode([
            'id' => $this->id,
            'dimension' => [
                $this->width,
                $this->height
            ],
            'offset' => [
                $this->offset['x'],
                $this->offset['y']
            ],
            'filename' => $filename
        ]);
        
        return $src;
    }

    public function setDimensions(){

        if (isset($this->args['width'])) {
            $this->width = (int) $this->args['width'];
        }

        if (isset($this->args['height'])) {
            $this->height = (int) $this->args['height'];
        }

        if(($this->width!==NULL) && ($this->height!==NULL)){
            return true;
        }

        if(($this->width!==NULL) && ($this->height===NULL)){
            $this->height = getHeight();
            return true;
        }

        if(($this->width===NULL) && ($this->height!==NULL)){
            $this->width = getWidth();
            return true;
        }

        // nether width or height provided
        if(($this->width===NULL) && ($this->height===NULL)){
            // do not attempt to resize
            return false;
        }
    }


    public function onLoad(){
        $this->setDimensions();

        if (isset($this->args['alt'])) {
            $this->alt = (string) $this->args['alt'];
        }

        if (isset($this->args['offset'])) {
            list($this->offset['x'], $this->offset['y']) = explode(',', $this->args['offset']);
        }

        $this->source = $this->getCacheURL($this->source);
    }

    public function onRender()
    {
        return <<<HTML
<img src="{$this->source}" alt="{$this->alt}" width="{$this->width}" height="{$this->height}"/>
HTML;
    }

    public function __debugInfo()
    {
        return [
            'alt' => $this->alt,
            'width' => $this->width,
            'height' => $this->height,
            'offset' => [
                'x' => $this->offset['x'],
                'y' => $this->offset['y']
            ]
        ];
    }


    /*
     * // collection
     *
     * // focal-point="200x100"
     * original
     *
     * focus_point x: -0.27 y: +0.033+
     * focal-point="-0.27,0.33"
     * 100x100
     */

    // srcset specified images to use in different situations
    // sizes
    // resize
    // store focal point
    // alt

    // id / X-Y / X-Y . jpg
    public function onSubmit()
    {
    }

    public function focalPointForm()
    {
        return <<<HTML
		<form method="post">
			<input type="image" name="focal_point" src="/assets/images/livingMarkup/logo/original.jpg"/>
		</form>
HTML;
    }
}
