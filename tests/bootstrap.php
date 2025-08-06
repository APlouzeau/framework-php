<?php

// Simple bootstrap for EyoPHP tests
require_once __DIR__ . '/../vendor/autoload.php';

// Define paths
define('APP_PATH', realpath(__DIR__ . '/../') . '/');
define('BASE_URL', '/');

// Les exceptions sont maintenant chargées automatiquement via autoloader PSR-4
// require_once APP_PATH . 'class/ClassNotFoundException.php'; // Obsolète

// Load configuration
require_once APP_PATH . 'config/config.php';

// Load aliases for backward compatibility
require_once APP_PATH . 'src/aliases.php';

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
