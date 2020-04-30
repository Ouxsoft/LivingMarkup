<?php require 'vendor/autoload.php';

add_module([
    'name' => 'ReactNativeWebView',
    'class_name' => 'LivingMarkup\Modules\Custom\Examples\ReactNativeWebView',
    'xpath' => '//webview',
]);
?><!doctype html>
<html>
<head>
    <title>Example Domain</title>
</head>

<body>
<div>
    <webview>
        <arg name="initiate">true</arg>
        <arg name="object">{"key": 123}</arg>
        <h1>This is the body for webview</h1>
    </webview>
</div>
</body>
</html>
