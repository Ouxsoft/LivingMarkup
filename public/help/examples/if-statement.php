<?php require 'vendor/autoload.php';

// define a datetime to allow consistent display results
// comment out to default to NOW
define('LivingMarkup_DATETIME', '2019-12-03 01:30:00');

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
        <h1>If Statement</h1>
        <p>
            An if statement is a programming conditional statement that, if proved true, displays information
            contained within. If statements are provided to empower users but should be used sparingly. It is better for
            complex nested logic to be separated into a module.
        </p>
        <h2>Conditions</h2>
        <p>An if statement toggle is based on one more more conditional checks. These checks are supplied as arguments.</p>
        <h3>Time</h3>
        <p>A condition based on the time of day.</p>
        <code process="false">
            <if time_start="0:00" time_end="23:59">
                <p>Good morning.</p>
            </if>
            <if time_start="12:00pm" time_end="3:59pm">
                <p>Good day.</p>
            </if>
            <if>
                <arg name="time_start">4:00pm</arg>
                <arg name="time_end">11:59pm</arg>
                <p>Good evening.</p>
            </if>
        </code>

        <h3>Day of Week</h3>
        <p>A condition based on the day of the week.</p>
        <code process="false">
            <if>
                <arg name="day_of_week">Tuesday</arg>
                <arg name="day_of_week">Friday</arg>
                <p>You've come during Tuesday and Friday sale!</p>
            </if>
            <if>
                <arg name="day_of_week">Sunday</arg>
                <arg name="day_of_week">Saturday</arg>
                <p>You've come during our weekend sale!</p>
            </if>
        </code>

        <h3>Date</h3>
        <p>A condition based on dates.</p>
        <code process="false">
            <if>
                <arg name="date_start">December 3. 2019</arg>
                <arg name="date_end">December 3, 2019</arg>
                <arg name="else">
                    <p>Regular shipping rates apply.</p>
                </arg>
                <p>We are offering FREE shipping for a limited time.</p>
            </if>
        </code>

        <h3>Datetime</h3>
        <p>A condition based on datetimes.</p>
        <code process="false">
            <if>
                <arg name="datetime_start">December 4. 2019 1:00 am</arg>
                <arg name="datetime_end">December 4, 2019 2:00 am</arg>
                <arg name="else">
                    <p>FREE pen with each order.</p>
                </arg>
                <p>FREE limited edition mousepad with each order.</p>
            </if>
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