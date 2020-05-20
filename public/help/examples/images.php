<?php require 'vendor/autoload.php'; ?>

<!--
  ~ This file is part of the LivingMarkup package.
  ~
  ~ (c) Matthew Heroux <matthewheroux@gmail.com>
  ~
  ~ For the full copyright and license information, please view the LICENSE
  ~ file that was distributed with this source code.
  -->

<html lang="en">
<head>
    <title>If Statement</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link href="/assets/css/main.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/codemirror/codemirror.css"/>
    <script src="/assets/js/codemirror/codemirror.js"/>
    <script src="/assets/js/codemirror/xml.js"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/codemirror/dracula.css"/>
</head>
<body>

    <partial name="HeaderDefault"/>
    <partial name="Breadcrumb"/>

    <main role="main" class="container">
        <h1>Images</h1>
        <p>
            Images can be automatically resized for your need. Simply upload large images and have them resized on the fly.
        </p>
        <h2>Parameters</h2>
        <p>Local images with parameters inside the request are automatically adjusted and cached.</p>
        <h3>Resizing Image</h3>
        <p>Images can be resized on the fly using parameterized requests</p>
        <code process="false">
            <!-- resize by height -->
            <img src="/assets/images/height/50/livingmarkup/logo/original.jpg" alt="LivingMarkup" />
            <!-- resize by width -->
            <img src="/assets/images/width/50/livingmarkup/logo/original.jpg" alt="LivingMarkup" />
            <!-- resize by width and height -->
            <img src="/assets/images/width/50/height/50/livingmarkup/logo/original.jpg" alt="LivingMarkup" />
            <!-- resize by width and height using dimension parameter -->
            <img src="/assets/images/dimension/50x50/livingmarkup/logo/original.jpg" alt="LivingMarkup" />
        </code>
        <h3>Offset</h3>
        <p>
            Set the focal point of an image using offsets. The syntax is X%,Y% with values ranging from -50 to 50 with 0 being center.
        </p>
        <code process="false">
            <!-- center -->
            <img src="/assets/images/dimension/50x50/offset/0,0/livingmarkup/logo/original.jpg" alt="LivingMarkup" />
            <!-- left -->
            <img src="/assets/images/dimension/50x50/offset/-50,0/livingmarkup/logo/original.jpg" alt="LivingMarkup" />
            <!-- right -->
            <img src="/assets/images/dimension/50x50/offset/50,0/livingmarkup/logo/original.jpg" alt="LivingMarkup" />
            <!-- top -->
            <img src="/assets/images/dimension/50x50/offset/0,-50/livingmarkup/logo/original.jpg" alt="LivingMarkup" />
            <!-- bottom -->
            <img src="/assets/images/dimension/50x50/offset/0,50/livingmarkup/logo/original.jpg" alt="LivingMarkup" />
        </code>
    </main>

    <script type="text/javascript" src="/assets/js/bootstrap/bootstrap.min.js"></script>
    <script src="/assets/js/jquery/jquery.min.js"></script>

    <script>
        function qsa(sel) {
            return Array.apply(null, document.querySelectorAll(sel));
        }
        qsa(".codemirror-textarea").forEach(function (editorEl) {
            CodeMirror.fromTextArea(editorEl, {
                lineNumbers: true,
                styleActiveLine: true,
                matchBrackets: true,
                mode : "xml",
                htmlMode: true,
                theme: "dracula"
            });
        });
    </script>
</body>
</html>