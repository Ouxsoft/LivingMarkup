<?php

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

date_default_timezone_set('UTC');

// ensures that notices can be caught by tests
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
