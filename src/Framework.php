<?php

namespace EyoPHP\Framework;

/**
 * Framework - Main entry point for EyoPHP framework
 *
 * @package EyoPHP\Framework
 * @author  Alexandre PLOUZEAU
 * @version 0.1.0
 */
class Framework
{
    /**
     * Framework version
     */
    public const VERSION = '0.1.0';

    /**
     * Initialize the framework with default configuration
     */
    public static function init(): void
    {
        // Start session if not already done
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Define constants if not already done
        if (!defined('APP_PATH')) {
            define('APP_PATH', getcwd() . '/');
        }

        if (!defined('BASE_URL')) {
            define('BASE_URL', '/');
        }
    }

    /**
     * Return the framework version
     */
    public static function version(): string
    {
        return self::VERSION;
    }
}
