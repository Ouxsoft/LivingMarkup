<?php require 'vendor/autoload.php';

add_module([
    'name' => 'Widget',
    'class_name' => 'LivingMarkup\Modules\Custom\Examples\HelloWorld',
    'xpath' => '//widget',
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

<html lang="en">
<body>
	<widget name="HelloWorld"/>
</body>
</html>