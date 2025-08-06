<?php

namespace EyoPHP\Framework\Middleware;

/**
 * MiddlewareManager - Gestionnaire des middlewares
 *
 * Gère l'exécution des middlewares avant et après les contrôleurs
 *
 * @package EyoPHP\Framework\Middleware
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */
class MiddlewareManager
{
    /**
     * @var array Liste des middlewares globaux
     */
    private static array $globalMiddlewares = [];

    /**
     * @var array Liste des middlewares par route
     */
    private static array $routeMiddlewares = [];

    /**
     * Ajouter un middleware global
     *
     * S'exécute sur toutes les routes
     *
     * @param string $middlewareClass Nom de la classe middleware
     */
    public static function addGlobal(string $middlewareClass): void
    {
        if (class_exists($middlewareClass)) {
            self::$globalMiddlewares[] = $middlewareClass;
        }
    }

    /**
     * Ajouter un middleware à une route spécifique
     *
     * @param string $route Pattern de route (ex: /user/{id})
     * @param string $middlewareClass Nom de la classe middleware
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
