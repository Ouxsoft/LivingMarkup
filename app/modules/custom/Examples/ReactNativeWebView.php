<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Modules\Custom\Examples;

use LivingMarkup\Module;

class ReactNativeWebView extends Module
{
    public function onRender()
    {
        if ($this->args['initiate'] == "true" && !empty($this->args['object'])) {
            $object = $this->args['object']; // escape JSON
            return "<script>
                window.ReactNativeWebView.postMesage({$object}, '*');
            </script>" . $this->xml;
        }
        
        return $this->xml;
    }
}
