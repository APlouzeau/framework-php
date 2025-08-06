<?php

/**
 * ClassMiddlewareCors - Middleware CORS
 *
 * Gère les en-têtes CORS pour les API
 *
 * @package EyoPHP\Framework\Middleware
 * @author  Alexandre PLOUZEAU
 * @version 1.0.0
 */
class ClassMiddlewareCors extends ClassMiddleware
{
    /**
     * Ajouter les en-têtes CORS
     */
    public function before(array $request): bool
    {
        // Permettre toutes les origines (à adapter selon vos besoins)
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        header('Access-Control-Max-Age: 86400'); // 24 heures

        // Gérer les requêtes OPTIONS (preflight)
        if ($request['method'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        return true;
    }
}
