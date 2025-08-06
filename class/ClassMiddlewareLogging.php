<?php

/**
 * ClassMiddlewareLogging - Middleware de journalisation
 *
 * Enregistre toutes les requêtes dans les logs
 *
 * @package EyoPHP\Framework\Middleware
 * @author  Alexandre PLOUZEAU
 * @version 1.0.0
 */
class ClassMiddlewareLogging extends ClassMiddleware
{
    /**
     * Journaliser la requête entrante
     */
    public function before(array $request): bool
    {
        $logMessage = sprintf(
            "[%s] %s %s - IP: %s - User-Agent: %s",
            date('Y-m-d H:i:s'),
            $request['method'] ?? 'UNKNOWN',
            $request['uri'] ?? '/',
            $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        );

        error_log($logMessage, 3, APP_PATH . 'logs/requests.log');

        return true; // Toujours continuer
    }

    /**
     * Journaliser la réponse
     */
    public function after(array $request, mixed $response = null): void
    {
        $logMessage = sprintf(
            "[%s] Response for %s %s - Status: %d",
            date('Y-m-d H:i:s'),
            $request['method'] ?? 'UNKNOWN',
            $request['uri'] ?? '/',
            http_response_code()
        );

        error_log($logMessage, 3, APP_PATH . 'logs/requests.log');
    }
}
