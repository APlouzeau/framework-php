<?php

/**
 * EyoPHP Framework Bootstrap
 *
 * Ce fichier initialise le framework et configure l'autoloader Composer
 * ainsi que la compatibilité avec les anciennes classes.
 *
 * @package EyoPHP\Framework
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */

// Charger l'autoloader Composer
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
} else {
    // Fallback: autoloader simple pour le développement
    spl_autoload_register(function ($class) {
        // Autoloader pour les classes namespaced EyoPHP\Framework
        if (strpos($class, 'EyoPHP\\Framework\\') === 0) {
            $relativeClass = substr($class, strlen('EyoPHP\\Framework\\'));
            $file = __DIR__ . '/src/' . str_replace('\\', '/', $relativeClass) . '.php';

            if (file_exists($file)) {
                require $file;
            }
        }

        // Autoloader pour les anciennes classes
        if (strpos($class, 'Class') === 0) {
            $file = __DIR__ . '/class/' . $class . '.php';

            if (file_exists($file)) {
                require $file;
            }
        }
    });
}

// Charger la configuration
if (file_exists(__DIR__ . '/config/config.php')) {
    require_once __DIR__ . '/config/config.php';
}

// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Alias pour compatibilité descendante
class_alias('EyoPHP\\Framework\\Core\\Router', 'Router');
class_alias('EyoPHP\\Framework\\Core\\Database', 'Database');
class_alias('EyoPHP\\Framework\\Validation\\Validator', 'Validator');
class_alias('EyoPHP\\Framework\\Middleware\\Middleware', 'Middleware');
class_alias('EyoPHP\\Framework\\Middleware\\MiddlewareManager', 'MiddlewareManager');
class_alias('EyoPHP\\Framework\\Middleware\\UserMiddleware', 'UserMiddleware');
class_alias('EyoPHP\\Framework\\Middleware\\AdminMiddleware', 'AdminMiddleware');
