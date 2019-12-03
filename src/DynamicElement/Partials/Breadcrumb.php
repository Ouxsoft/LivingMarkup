<?php
namespace Pxp\DynamicElement\Partials;

/**
 * Class Breadcrumb
 *
 * Returns a breadcrumb trail for currebt oage
 *
 * @package Pxp\DynamicElement\Partials
 */
class Breadcrumb extends \Pxp\DynamicElement\DynamicElement
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