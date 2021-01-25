<?php

use LivingMarkup\Factory\ProcessorFactory;

require 'vendor/autoload.php';

$processor = ProcessorFactory::getInstance();

$processor->loadConfig('test/src/Resource/config/phpunit.json');
echo $processor->parseString('<html><bitwise>
<arg name="number">2</arg>
<arg name="count">6</arg>
<arg name="operator">^</arg>
</bitwise></html>');

$config = $processor->getConfig();

var_export($config);