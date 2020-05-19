<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Modules\Custom\Partials;

use LivingMarkup\Module;

/**
 * Class Breadcrumb
 *
 * Returns a breadcrumb trail for currebt oage
 *
 * @package LivingMarkup\Modules\Partials
 */
class Breadcrumb extends Module
{
    public $separator = '/';

    /**
     * Renders a breadcrumb trail for the current page
     *
     * TODO: get current page
     *
     * @return mixed|string
     */
    public function onRender()
    {
        $pages = [
            [
                'title' => 'Home',
                'href' => '/'
            ]
        ];

        $out = '<!-- Breadcrumb -->' . PHP_EOL;
        $out .= '<nav aria-label="breadcrumb">';
        $out .= '<ol class="breadcrumb mb-0">';
        foreach ($pages as $page) {
            $out .= '<li class="breadcrumb-item active" aria-current="page">';
            $out .= '<span class="separator">' . $this->separator . '</span> ';
            $out .= '<a href="' . $page['href'] . '">';
            $out .= $page['title'];
            $out .= '</a>';
            $out .= '</li>';
        }
        $out .= '</ol>';
        $out .= '</nav>';
        return $out;
    }
}
