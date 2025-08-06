<?php

/**
 * ClassMiddlewareUser - Middleware pour utilisateurs connectés
 *
 * Vérifie que l'utilisateur est connecté (peu importe le rôle)
 */
class ClassMiddlewareUser extends ClassMiddleware
{
    public function before(array $request): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function halt(array $request): void
    {
        if (strpos($request['uri'] ?? '', '/api/') === 0) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode([
                'error' => ClassTranslation::get('auth.login.required'),
                'code' => 401
            ]);
        } else {
            header('Location: /login');
        }
        exit;
    }
}

/**
 * ClassMiddlewareAdmin - Middleware pour administrateurs uniquement
 *
 * Vérifie que l'utilisateur est connecté ET a le rôle admin
 */
class ClassMiddlewareAdmin extends ClassMiddleware
{
    public function before(array $request): bool
    {
        // Vérifier connexion ET rôle admin
        return isset($_SESSION['user_id']) && ($_SESSION['user_role'] ?? '') === 'admin';
    }

    public function halt(array $request): void
    {
        // Si pas connecté du tout
        if (!isset($_SESSION['user_id'])) {
            if (strpos($request['uri'] ?? '', '/api/') === 0) {
                http_response_code(401);
                header('Content-Type: application/json');
                echo json_encode([
                    'error' => ClassTranslation::get('auth.login.required'),
                    'code' => 401
                ]);
            } else {
                header('Location: /login');
            }
        } else {
            // Connecté mais pas admin
            if (strpos($request['uri'] ?? '', '/api/') === 0) {
                http_response_code(403);
                header('Content-Type: application/json');
                echo json_encode([
                    'error' => ClassTranslation::get('errors.access_denied'),
                    'code' => 403,
                    'message' => 'Droits administrateur requis'
                ]);
            } else {
                http_response_code(403);
                echo "<h1>Accès refusé</h1><p>Cette page est réservée aux administrateurs.</p>";
            }
        }
        exit;
    }
}
