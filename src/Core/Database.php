<?php

namespace EyoPHP\Framework\Core;

use PDO;
use PDOException;

/**
 * Database - Gestionnaire de base de données avec PDO
 *
 * Fournit une connexion singleton à la base de données
 *
 * @package EyoPHP\Framework\Core
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */
class Database
{
    /**
     * @var PDO|null Instance de connexion PDO
     */
    public ?PDO $conn;

    /**
     * @var Database|null Instance singleton
     */
    private static ?Database $instance = null;

    /**
     * Constructeur privé pour singleton
     */
    private function __construct()
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
            throw new \RuntimeException("La connexion à la base de données a échoué: " . $e->getMessage());
        }
    }

    /**
     * Constructeur public pour compatibilité avec l'ancienne version
     */
    public function __constructLegacy()
    {
        $this->conn = self::getInstance()->getConnection();
    }

    /**
     * Obtenir l'instance singleton de la base de données
     *
     * @return Database Instance de la base de données
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Obtenir la connexion PDO
     *
     * @return PDO Connexion PDO
     */
    public function getConnection(): PDO
    {
        return $this->conn;
    }

    /**
     * Exécuter une requête préparée
     *
     * @param string $query Requête SQL
     * @param array $params Paramètres de la requête
     * @return \PDOStatement Résultat de la requête
     */
    public function query(string $query, array $params = []): \PDOStatement
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Exécuter une requête et retourner le premier résultat
     *
     * @param string $query Requête SQL
     * @param array $params Paramètres de la requête
     * @return array|false Premier résultat ou false
     */
    public function fetch(string $query, array $params = [])
    {
        return $this->query($query, $params)->fetch();
    }

    /**
     * Exécuter une requête et retourner tous les résultats
     *
     * @param string $query Requête SQL
     * @param array $params Paramètres de la requête
     * @return array Tous les résultats
     */
    public function fetchAll(string $query, array $params = []): array
    {
        return $this->query($query, $params)->fetchAll();
    }

    /**
     * Obtenir l'ID du dernier enregistrement inséré
     *
     * @return string|false ID du dernier insert
     */
    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    /**
     * Commencer une transaction
     *
     * @return bool True en cas de succès
     */
    public function beginTransaction(): bool
    {
        return $this->conn->beginTransaction();
    }

    /**
     * Valider une transaction
     *
     * @return bool True en cas de succès
     */
    public function commit(): bool
    {
        return $this->conn->commit();
    }

    /**
     * Annuler une transaction
     *
     * @return bool True en cas de succès
     */
    public function rollBack(): bool
    {
        return $this->conn->rollBack();
    }

    /**
     * Empêcher le clonage
     */
    private function __clone() {}

    /**
     * Empêcher la désérialisation
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}
