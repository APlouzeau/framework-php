<?php

/**
 * Bootstrap file for EyoPHP Framework
 * This file initializes the framework for testing and development
 */

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define framework root path
define('FRAMEWORK_ROOT', __DIR__);

// Include Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Add custom autoloader for legacy classes if needed
spl_autoload_register(function ($class) {
    // Convert namespace to file path
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    // Check in src directory
    $srcFile = __DIR__ . '/src/' . $file;
    if (file_exists($srcFile)) {
        require_once $srcFile;
        return true;
    }

    // Check in class directory for legacy classes
    $classFile = __DIR__ . '/class/' . basename($file);
    if (file_exists($classFile)) {
        require_once $classFile;
        return true;
    }

    return false;
});

// Set default timezone
date_default_timezone_set('Europe/Paris');
