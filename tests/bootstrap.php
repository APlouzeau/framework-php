<?php

/**
 * Bootstrap for PHPUnit tests
 * 
 * This file is loaded before running tests to set up the environment
 * 
 * @package EyoPHP\Framework\Tests
 * @author  Alexandre PLOUZEAU
 */

// Enable error reporting for tests
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define framework root path
define('FRAMEWORK_ROOT', dirname(__DIR__));

// Include Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

// Set default timezone
date_default_timezone_set('Europe/Paris');

// Test environment marker
define('APP_ENV', 'testing');
