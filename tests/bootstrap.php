<?php

/**
 * Bootstrap pour les tests EyoPHP Framework
 * 
 * @package EyoPHP\Framework\Tests
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */

// Chargement de l'autoloader Composer (PSR-4)
require_once __DIR__ . '/../vendor/autoload.php';

// Définition des constantes de chemin
if (!defined('APP_PATH')) {
    define('APP_PATH', realpath(__DIR__ . '/../') . '/');
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '/');
}

// Initialisation du framework pour les tests
\EyoPHP\Framework\Framework::init();

// Chargement de la configuration si elle existe
$configFile = APP_PATH . 'config/config.php';
if (file_exists($configFile)) {
    require_once $configFile;
}
