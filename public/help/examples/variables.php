<?php require 'vendor/autoload.php';

add_module([
    'name' => 'Block',
    'class_name' => 'LivingMarkup\Modules\Custom\Examples\{name}',
    'xpath' => '//block',
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
	<block name="GroupProfile">
		<fieldset>
			<legend>Group:</legend>
			<var name="group"/>

			<block name="UserProfile">
				<p>Welcome <var tag="block" name="first_name"/> <var name="last_name"/></p>
			</block>
		</fieldset>
	</block>
</body>
</html>