<?php

/**
 * Configuration générale du framework EyoPHP
 * 
 * @package EyoPHP\Framework
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */

// Configuration de l'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
define('DEBUG', true); // Mettre à false en production
define('ENVIRONMENT', 'development'); // development, production, testing

// Configuration de la base de données
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_NAME', $_ENV['DB_NAME'] ?? '');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? '');
define('DB_PORT', $_ENV['DB_PORT'] ?? '3306');

// Configuration des erreurs
if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
}

// Configuration de la timezone
date_default_timezone_set('Europe/Paris');

// Configuration des sessions
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);

// Configuration sécurité
if (!DEBUG) {
    // En production seulement
    ini_set('session.cookie_secure', 1);
}

// Initialisation du framework (constantes et autoloaders)
\EyoPHP\Framework\Framework::init();
