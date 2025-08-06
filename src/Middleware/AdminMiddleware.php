<?php

namespace EyoPHP\Framework\Middleware;

/**
 * AdminMiddleware - Middleware d'authentification administrateur
 *
 * Vérifie que l'utilisateur est connecté et a les droits administrateur
 *
 * @package EyoPHP\Framework\Middleware
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */
class AdminMiddleware extends UserMiddleware
{
    /**
     * Vérifier l'authentification et les droits admin
     *
     * @param array $request Données de la requête
     * @return bool True si utilisateur admin, False sinon
     */
    public function before(array $request): bool
    {
        // D'abord vérifier l'authentification de base
        if (!parent::before($request)) {
            return false;
        }

        // Vérifier le rôle administrateur
        $userRole = $_SESSION['user_role'] ?? 'user';

        return $userRole === 'admin';
    }

    /**
     * Gérer l'accès refusé pour admin
     *
     * @param array $request Données de la requête
     * @return void
     */
    public function halt(array $request): void
    {
        // Si l'utilisateur n'est pas connecté, rediriger vers login
        if (!isset($_SESSION['user_id'])) {
            parent::halt($request);
            return;
        }

        // Si connecté mais pas admin, erreur 403
        if (strpos($request['uri'] ?? '', '/api/') === 0) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode([
                'error' => 'Droits administrateur requis',
                'code' => 403
            ]);
        } else {
            http_response_code(403);
            echo "Erreur 403 : Accès refusé. Droits administrateur requis.";
        }
        exit;
    }
}
