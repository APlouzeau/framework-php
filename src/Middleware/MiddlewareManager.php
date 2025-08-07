<?php

namespace EyoPHP\Framework\Middleware;

/**
 * MiddlewareManager - Middleware manager
 *
 * Manages middleware execution before and after controllers
 *
 * @package EyoPHP\Framework\Middleware
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */
class MiddlewareManager
{
    /**
     * @var array List of global middlewares
     */
    private static array $globalMiddlewares = [];

    /**
     * @var array List of route-specific middlewares
     */
    private static array $routeMiddlewares = [];

    /**
     * Add a global middleware
     *
     * Executes on all routes
     *
     * @param string $middlewareClass Middleware class name
     */
    public static function addGlobal(string $middlewareClass): void
    {
        if (class_exists($middlewareClass)) {
            self::$globalMiddlewares[] = $middlewareClass;
        }
    }

    /**
     * Add a middleware to a specific route
     *
     * @param string $route Route pattern (e.g.: /user/{id})
     * @param string $middlewareClass Middleware class name
     */
    public static function addToRoute(string $route, string $middlewareClass): void
    {
        if (!isset(self::$routeMiddlewares[$route])) {
            self::$routeMiddlewares[$route] = [];
        }

        if (class_exists($middlewareClass)) {
            self::$routeMiddlewares[$route][] = $middlewareClass;
        }
    }

    /**
     * Exécuter les middlewares avant le contrôleur
     *
     * @param array $request Données de la requête
     * @return bool True pour continuer, False pour arrêter
     */
    public static function runBefore(array $request): bool
    {
        $middlewares = self::getMiddlewaresForRequest($request);

        foreach ($middlewares as $middlewareClass) {
            $middleware = new $middlewareClass();

            if (!$middleware->before($request)) {
                $middleware->halt($request);
                return false;
            }
        }

        return true;
    }

    /**
     * Exécuter les middlewares après le contrôleur
     *
     * @param array $request Données de la requête
     * @param mixed $response Réponse du contrôleur
     */
    public static function runAfter(array $request, mixed $response = null): void
    {
        $middlewares = self::getMiddlewaresForRequest($request);

        // Exécuter dans l'ordre inverse (LIFO)
        foreach (array_reverse($middlewares) as $middlewareClass) {
            $middleware = new $middlewareClass();
            $middleware->after($request, $response);
        }
    }

    /**
     * Obtenir tous les middlewares pour une requête
     *
     * @param array $request Données de la requête
     * @return array Liste des classes middleware
     */
    private static function getMiddlewaresForRequest(array $request): array
    {
        $middlewares = self::$globalMiddlewares;

        // Ajouter les middlewares spécifiques à la route
        if (isset($request['path'])) {
            $routePath = $request['path'];
            if (isset(self::$routeMiddlewares[$routePath])) {
                $middlewares = array_merge($middlewares, self::$routeMiddlewares[$routePath]);
            }
        }

        return array_unique($middlewares);
    }

    /**
     * Obtenir la liste des middlewares enregistrés
     *
     * @return array Middlewares globaux et par route
     */
    public static function getRegisteredMiddlewares(): array
    {
        return [
            'global' => self::$globalMiddlewares,
            'routes' => self::$routeMiddlewares
        ];
    }
}
