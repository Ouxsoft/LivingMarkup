<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Component\Widgets;

use LivingMarkup\Component\Component;

/**
 * Class News
 *
 *
 * <widget name="News">
 * <arg name="heading">Latest News</arg>
 * <arg name="heading_level">3</arg>
 * </widget>
 *
 * @package LivingMarkup\Component\Widgets
 */
class News extends Component
{
    public $heading_level = 3;

    /**
     * Renders news
     *
     * TODO: Add function call for modular database api
     *
     * @return mixed|string
     */
    public function onRender()
    {
        $out = '';

        // add widget comment
        if (isset($this->args['id'])) {
            $out .= '<!-- widget #' . $this->args['id'] . '-->' . PHP_EOL;
        }

        // heading
        if (isset($this->args['heading'])) {
            if (isset($this->args['heading_level']) && (in_array($this->args['heading_level'], range(1, 6)))) {
                $this->heading_level = $this->args['heading_level'];
            }

            $out .= '<h' . $this->heading_level . '>' . $this->args['heading'] . '</h' . $this->heading_level . '>';
        }

        /*
         * $out .= '<ul>';
         * foreach($this->myGenerator() as $row){
         * $out .= '<li>' . $row . '</li>';
         * }
         * $out .= '</ul>';
         */
        return $out;
    }
}
