<?php

namespace EyoPHP\Framework;

/**
 * Framework - Point d'entrée principal du framework EyoPHP
 *
 * @package EyoPHP\Framework
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */
class Framework
{
    /**
     * Version du framework
     */
    public const VERSION = '2.0.0';

    /**
     * Initialise le framework avec la configuration par défaut
     */
    public static function init(): void
    {
        // Démarrage de session si pas déjà fait
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Définir les constantes si pas déjà fait
        if (!defined('APP_PATH')) {
            define('APP_PATH', getcwd() . '/');
        }

        if (!defined('BASE_URL')) {
            define('BASE_URL', '/');
        }
    }

    /**
     * Retourne la version du framework
     */
    public static function version(): string
    {
        return self::VERSION;
    }
}
