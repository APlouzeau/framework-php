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
     * Execute middlewares before controller
     *
     * @param array $request Request data
     * @return bool True to continue, False to stop
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
     * Execute middlewares after controller
     *
     * @param array $request Request data
     * @param mixed $response Controller response
     */
    public static function runAfter(array $request, mixed $response = null): void
    {
        $middlewares = self::getMiddlewaresForRequest($request);

        // Execute in reverse order (LIFO)
        foreach (array_reverse($middlewares) as $middlewareClass) {
            $middleware = new $middlewareClass();
            $middleware->after($request, $response);
        }
    }

    /**
     * Get all middlewares for a request
     *
     * @param array $request Request data
     * @return array List of middleware classes
     */
    private static function getMiddlewaresForRequest(array $request): array
    {
        $middlewares = self::$globalMiddlewares;

        // Add route-specific middlewares
        if (isset($request['path'])) {
            $routePath = $request['path'];
            if (isset(self::$routeMiddlewares[$routePath])) {
                $middlewares = array_merge($middlewares, self::$routeMiddlewares[$routePath]);
            }
        }

        return array_unique($middlewares);
    }

    /**
     * Get the list of registered middlewares
     *
     * @return array Global and route-specific middlewares
     */
    public static function getRegisteredMiddlewares(): array
    {
        return [
            'global' => self::$globalMiddlewares,
            'routes' => self::$routeMiddlewares
        ];
    }
}
