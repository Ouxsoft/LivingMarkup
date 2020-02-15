<?php require __DIR__ . '/../../vendor/autoload.php';

add_module([
    'name' => 'Bitwise',
    'class_name' => 'LivingMarkup\Examples\Bitwise\Bitwise',
    'xpath' => '//bitwise',
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
    <body>
        <h2>BitWise Example</h2>
        <bitwise>
            <arg name="number">2</arg>
            <arg name="count">6</arg>
            <arg name="operator">^</arg>
        </bitwise>
    </body>
</html>