<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Aswin Vijayakumar <aswinkvj@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Examples\WebView;

class ReactNativeWebView extends \LivingMarkup\Module
{
    public function onRender()
    {
        if($this->args['initiate'] == "true" && !empty($this->args['object'])) {
            $object = $this->args['object']; // escape JSON
            return "<script>
                window.ReactNativeWebView.postMesage({$object}, '*');
            </script>";
        }
        
        return '<body>' . $this->xml . '</body>';
    }
}
