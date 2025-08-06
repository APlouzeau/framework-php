<?php

namespace EyoPHP\Framework\Middleware;

/**
 * Middleware - Interface de base pour tous les middlewares
 *
 * Les middlewares s'exécutent avant et après les contrôleurs
 * pour gérer l'authentification, les logs, CORS, etc.
 *
 * @package EyoPHP\Framework\Middleware
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */
abstract class Middleware
{
    /**
     * Exécuter le middleware avant le contrôleur
     *
     * @param array $request Données de la requête (method, uri, parameters)
     * @return bool True pour continuer, False pour arrêter
     */
    abstract public function before(array $request): bool;

    /**
     * Exécuter le middleware après le contrôleur
     *
     * @param array $request Données de la requête
     * @param mixed $response Réponse du contrôleur
     * @return void
     */
    public function after(array $request, mixed $response = null): void
    {
        // Implémentation optionnelle par défaut
    }

    /**
     * Gérer l'arrêt du middleware
     *
     * Appelé quand before() retourne false
     *
     * @param array $request Données de la requête
     * @return void
     */
    public function halt(array $request): void
    {
        // Implémentation par défaut : erreur 403
        http_response_code(403);
        echo json_encode([
            'error' => 'Accès refusé',
            'code' => 403
        ]);
        exit;
    }
}
