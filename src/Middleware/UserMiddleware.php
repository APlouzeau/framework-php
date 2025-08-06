<?php

namespace EyoPHP\Framework\Middleware;

/**
 * UserMiddleware - Middleware d'authentification utilisateur
 *
 * Vérifie que l'utilisateur est connecté
 *
 * @package EyoPHP\Framework\Middleware
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */
class UserMiddleware extends Middleware
{
    /**
     * Vérifier l'authentification
     *
     * @param array $request Données de la requête
     * @return bool True si utilisateur connecté, False sinon
     */
    public function before(array $request): bool
    {
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            return false;
        }

        // Optionnel : vérifier la validité de la session
        if (isset($_SESSION['expires_at']) && $_SESSION['expires_at'] < time()) {
            session_destroy();
            return false;
        }

        return true;
    }

    /**
     * Rediriger vers la page de connexion
     *
     * @param array $request Données de la requête
     * @return void
     */
    public function halt(array $request): void
    {
        // Si c'est une requête API, retourner JSON
        if (strpos($request['uri'] ?? '', '/api/') === 0) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode([
                'error' => 'Authentification requise',
                'code' => 401
            ]);
        } else {
            // Rediriger vers la page de connexion
            header('Location: /login');
        }
        exit;
    }
}
