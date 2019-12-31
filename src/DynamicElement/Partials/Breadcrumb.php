<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pxp\DynamicElement\Partials;

use Pxp\DynamicElement\DynamicElement;

/**
 * Class Breadcrumb
 *
 * Returns a breadcrumb trail for currebt oage
 *
 * @package Pxp\DynamicElement\Partials
 */
class Breadcrumb extends DynamicElement
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
            ],
            [
                'title' => 'Groups',
                'href' => '/groups'
            ],
            [
                'title' => 'User',
                'href' => '/groups/user'
            ],
            [
                'title' => 'Settings',
                'href' => '/groups/user/settings'
            ]
        ];

        $out = '<!-- Breadcrumb -->' . PHP_EOL;
        $out .= '<div class="breadcrumb">';
        $out .= '<ul>';
        foreach ($pages as $page) {
            $out .= '<li>';
            $out .= '<span class="separator">' . $this->separator . '</span> ';
            $out .= '<a href="' . $page['href'] . '">';
            $out .= $page['title'];
            $out .= '</a>';
            $out .= '</li>';
        }
        $out .= '</ul>';
        $out .= '</div>';
        return $out;
    }
}
