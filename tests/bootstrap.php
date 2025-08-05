<?php

// Simple bootstrap for EyoPHP tests
require_once __DIR__ . '/../vendor/autoload.php';

// Define paths
define('APP_PATH', realpath(__DIR__ . '/../') . '/');
define('BASE_URL', '/');

// Load custom exception
require_once APP_PATH . 'class/ClassNotFoundException.php';

// Load configuration
require_once APP_PATH . 'config/config.php';

// Simple autoloader for our classes
spl_autoload_register(function ($class_name) {
    $directories = ['class/', 'controller/', 'model/', 'traits/'];

    foreach ($directories as $directory) {
        $file = APP_PATH . $directory . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    // Optional: throw exception if class not found
    // throw new ClassNotFoundException("Class not found: " . $class_name);
});
