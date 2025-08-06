<?php

namespace EyoPHP\Framework\Core;

use PDO;
use PDOException;

/**
 * LegacyDatabase - Version de la classe Database compatible avec l'ancien code
 *
 * @package EyoPHP\Framework\Core
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */
class LegacyDatabase
{
    /**
     * @var PDO Instance de connexion PDO (publique pour rétrocompatibilité)
     */
    public PDO $conn;

    /**
     * Constructeur public (comme l'ancienne version)
     */
    public function __construct()
    {
        try {
            $this->conn = new PDO(
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
            echo "La connexion à la base de données a échoué."; // Compatibilité ancienne version
        }
    }
}
