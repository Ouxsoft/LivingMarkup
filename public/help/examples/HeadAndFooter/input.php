<?php require 'vendor/autoload.php';

add_module([
    'name' => 'Footer',
    'class_name' => 'LivingMarkup\Modules\Custom\Examples\Footer',
    'xpath' => '//footer',
]);
add_module([
    'name' => 'Head',
    'class_name' => 'LivingMarkup\Modules\Custom\Examples\Head',
    'xpath' => '//head',
]);

?>
<!--
  ~ This file is part of the LivingMarkup package.
  ~
  ~ (c) Matthew Heroux <matthewheroux@gmail.com>
  ~
  ~ For the full copyright and license information, please view the LICENSE
  ~ file that was distributed with this source code.
  -->

<html>
<head></head>
    <body>
        <h1>Header and Footer Example</h1>
        <footer></footer>
    </body>
</html>