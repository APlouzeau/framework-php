<?php

/**
 * ClassMiddlewareRole - Middleware de gestion des rôles
 *
 * Vérifie que l'utilisateur a le rôle requis pour accéder à la route
 *
 * @package EyoPHP\Framework\Middleware
 * @author  Alexandre PLOUZEAU
 * @version 1.0.0
 */
class ClassMiddlewareRole extends ClassMiddleware
{
    private string $requiredRole;

    public function __construct(string $requiredRole = 'user')
    {
        $this->requiredRole = $requiredRole;
    }

    /**
     * Vérifier le rôle de l'utilisateur
     */
    public function before(array $request): bool
    {
        // D'abord vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            return false; // Pas connecté
        }

        // Récupérer le rôle de l'utilisateur depuis la session
        $userRole = $_SESSION['user_role'] ?? 'user';

        // Vérifier le rôle requis
        switch ($this->requiredRole) {
            case 'admin':
                return $userRole === 'admin';

            case 'user':
                return in_array($userRole, ['user', 'admin']); // Admin peut accéder aux pages user

            default:
                return false;
        }
    }

    /**
     * Redirection selon le type d'accès refusé
     */
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
            exit;
        }

        // Si connecté mais rôle insuffisant
        if (strpos($request['uri'] ?? '', '/api/') === 0) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode([
                'error' => ClassTranslation::get('errors.access_denied'),
                'code' => 403,
                'required_role' => $this->requiredRole
            ]);
        } else {
            // Page d'erreur ou redirection
            http_response_code(403);
            echo "<h1>Accès refusé</h1><p>Vous n'avez pas les permissions suffisantes pour accéder à cette page.</p>";
        }
        exit;
    }
}
