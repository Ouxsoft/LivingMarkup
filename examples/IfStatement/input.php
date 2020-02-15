<?php require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

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

<body>

	<h1>If Statement Examples</h1>

	<!-- time -->
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

	<!-- day of week -->
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

	<!-- date -->
	<if>
		<arg name="date_start">December 3. 2019</arg>
		<arg name="date_end">December 3, 2019</arg>
		<arg name="else">
			<p>Regular shipping rates apply.</p>
		</arg>
		<p>We are offering FREE shipping for a limited time.</p>
	</if>

	<!-- datetime -->
	<if>
		<arg name="datetime_start">December 4. 2019 1:00 am</arg>
		<arg name="datetime_end">December 4, 2019 2:00 am</arg>
		<arg name="else">
			<p>FREE pen with each order.</p>
		</arg>
		<p>FREE limited edition mousepad with each order.</p>
	</if>

</body>
</html>