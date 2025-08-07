<?php

namespace EyoPHP\Framework\Core;

use PDO;
use PDOException;

/**
 * Database - Simple PDO singleton
 *
 * Provides a singleton PDO connection to the database
 *
 * @package EyoPHP\Framework\Core
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */
class Database
{
    /**
     * @var PDO|null Singleton PDO instance
     */
    private static ?PDO $instance = null;

    /**
     * Private constructor to prevent instantiation
     */
    private function __construct() {}

    /**
     * Get the singleton PDO instance
     *
     * @return PDO PDO connection
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    "mysql:host=" . DB_HOST . "; dbname=" . DB_NAME,
                    DB_USER,
                    DB_PSW,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                    ]
                );
            } catch (PDOException $e) {
                error_log("Database connection failed: " . $e->getMessage());
                throw new \RuntimeException("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$instance;
    }

    /**
     * Prevent cloning
     */
    private function __clone() {}

    /**
     * Prevent unserialization
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}
