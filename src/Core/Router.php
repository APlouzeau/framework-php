<?php

namespace EyoPHP\Framework\Core;

use EyoPHP\Framework\Middleware\MiddlewareManager;

/**
 * Router - Routing system with dynamic parameters support
 *
 * Supports routes with parameters like /user/{id} or /post/{slug}
 *
 * @package EyoPHP\Framework\Core
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */
class Router
{
    /**
     * @var array List of registered routes
     */
    private array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    /**
     * Resolve controller name (short names to full namespaces)
     * 
     * @param string $controller Controller name (short or full)
     * @return string Full controller namespace
     */
    private function resolveController(string $controller): string
    {
        // If it doesn't contain \, it's a short name -> add namespace
        if (strpos($controller, '\\') === false) {
            return 'EyoPHP\\Framework\\Controller\\' . $controller;
        }

        // Otherwise return as is (full namespace already provided)
        return $controller;
    }

    /**
     * Add a route to the router
     *
     * @param string $method HTTP method (GET, POST, PUT, DELETE)
     * @param string $path Route path with optional parameters (e.g., /user/{id})
     * @param string $controller Controller class name
     * @param string $action Controller method name
     * @param array $middlewares Optional middlewares for this route
     */
    public function addRoute(string $method, string $path, string $controller, string $action, array $middlewares = []): void
    {
        // Automatically resolve controller name
        $resolvedController = $this->resolveController($controller);

        $route = [
            'method' => $method,
            'path' => $path,
            'controller' => $resolvedController,
            'action' => $action,
            'pattern' => $this->compilePattern($path),
            'middlewares' => $middlewares
        ];

        $this->routes[] = $route;

        // Automatically register route middlewares
        foreach ($middlewares as $middleware) {
            MiddlewareManager::addToRoute($path, $middleware);
        }
    }

    /**
     * Compile a route pattern into regex
     *
     * Converts /user/{id} to ^/user/([^/]+)$
     *
     * @param string $path Route path
     * @return string Compiled regex pattern
     */
    private function compilePattern(string $path): string
    {
        // Replace {param} directly with a capture group
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $path);

        // Escape remaining special characters
        $pattern = str_replace('/', '\/', $pattern);

        // Anchor the pattern
        return '/^' . $pattern . '$/';
    }

    /**
     * Extract parameter names from a route
     *
     * @param string $path Route path
     * @return array Parameter names
     */
    private function extractParameterNames(string $path): array
    {
        preg_match_all('/\{([^}]+)\}/', $path, $matches);
        return $matches[1] ?? [];
    }

    /**
     * Find the handler for a request
     *
     * @param string $method HTTP method
     * @param string $uri Request URI
     * @return array|false Route handler with parameters or false if not found
     */
    public function getHandler(string $method, string $uri)
    {
        foreach ($this->routes as $route) {
            // Check HTTP method
            if ($route['method'] !== $method) {
                continue;
            }

            // Test the pattern
            if (preg_match($route['pattern'], $uri, $matches)) {
                // Remove first element (full match)
                array_shift($matches);

                // Extract parameter names
                $paramNames = $this->extractParameterNames($route['path']);

                // Create associative array of parameters
                $parameters = [];
                foreach ($paramNames as $index => $name) {
                    $parameters[$name] = $matches[$index] ?? null;
                }

                return [
                    'controller' => $route['controller'],
                    'action' => $route['action'],
                    'parameters' => $parameters,
                    'method' => $route['method'],
                    'path' => $route['path']
                ];
            }
        }

        return false;
    }

    /**
     * Get all registered routes
     *
     * @return array All registered routes
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Generate a URL from a route name and parameters
     *
     * @param string $path Route path template
     * @param array $parameters Parameters to substitute
     * @return string Generated URL
     */
    public function generateUrl(string $path, array $parameters = []): string
    {
        $url = $path;

        foreach ($parameters as $key => $value) {
            $url = str_replace('{' . $key . '}', $value, $url);
        }

        return $url;
    }

    /**
     * Add a public route (without protection)
     *
     * @param string $method HTTP method
     * @param string $path Route path
     * @param string $controller Controller class
     * @param string $action Controller method
     */
    public function addPublicRoute(string $method, string $path, string $controller, string $action): void
    {
        $this->addRoute($method, $path, $controller, $action, []);
    }

    /**
     * Add a route for authenticated users
     *
     * @param string $method HTTP method
     * @param string $path Route path
     * @param string $controller Controller class
     * @param string $action Controller method
     */
    public function addUserRoute(string $method, string $path, string $controller, string $action): void
    {
        $this->addRoute($method, $path, $controller, $action, ['EyoPHP\\Framework\\Middleware\\UserMiddleware']);
    }

    /**
     * Add a route for administrators only
     *
     * @param string $method HTTP method
     * @param string $path Route path
     * @param string $controller Controller class
     * @param string $action Controller method
     */
    public function addAdminRoute(string $method, string $path, string $controller, string $action): void
    {
        $this->addRoute($method, $path, $controller, $action, ['EyoPHP\\Framework\\Middleware\\AdminMiddleware']);
    }
}
