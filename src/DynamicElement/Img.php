<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pxp\DynamicElement;

use Pxp\Path;

class Img extends DynamicElement
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

    public $width = 100;

    public $height = 100;

    // original file source
    public $source = 'blank.jpg';
    
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

    public function loadSourceInfo()
    {
        list($width, $height, $type, $attr) = getimagesize($filename);
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

    public function focalPointForm()
    {
        return <<<HTML
		<form method="post">
			<input type="image" name="focal_point" src="/assets/images/pxp/logo/original.jpg"/>
		</form>
HTML;
    }

    public function getCacheSrc()
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

    public function onRender()
    {
        /*
         * $width = $this->args['@attributes']['width'];
         *
         * $height = $this->args['@attributes']['height'];
         * TODO: finalize focal offset
         * $out .= 'y='.$_POST['focal_point_y'].'x='.$_POST['focal_point_x'];
         */
        if (isset($this->args['@attributes']['width'])) {
            $this->width = (int) $this->args['@attributes']['width'];
        }
        
        if (isset($this->args['@attributes']['height'])) {
            $this->height = (int) $this->args['@attributes']['height'];
        }
        
        if (isset($this->args['@attributes']['alt'])) {
            $this->alt = (string) $this->args['@attributes']['alt'];
        }
        
        if (isset($this->args['@attributes']['offset'])) {
            list($this->offset['x'], $this->offset['y']) = explode(',', $this->args['@attributes']['offset']);
        }
        
        $this->source = $this->getCacheSrc($this->source);
        
        return <<<HTML
<img src="{$this->source}" alt="{$this->alt}" width="{$this->width}px" height="{$this->height}px"/>
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
}
