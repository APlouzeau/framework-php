<?php

/**
 * ClassMiddlewareAuth - Middleware d'authentification
 *
 * Vérifie l'authentification de l'utilisateur
 *
 * @package EyoPHP\Framework\Middleware
 * @author  Alexandre PLOUZEAU
 * @version 1.0.0
 */
class ClassMiddlewareAuth extends ClassMiddleware
{
    /**
     * Vérifier l'authentification
     */
    public function before(array $request): bool
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            return false; // Arrêter la requête
        }

        // Optionnel : vérifier la validité de la session
        if (isset($_SESSION['expires_at']) && $_SESSION['expires_at'] < time()) {
            session_destroy();
            return false;
        }

        return true; // Utilisateur authentifié
    }

    /**
     * Rediriger vers la page de connexion
     */
    public function halt(array $request): void
    {
        // Si c'est une requête API, retourner JSON
        if (strpos($request['uri'] ?? '', '/api/') === 0) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode([
                'error' => ClassTranslation::get('auth.login.required'),
                'code' => 401
            ]);
        } else {
            // Rediriger vers la page de connexion
            header('Location: /login');
        }
        exit;
    }
}
