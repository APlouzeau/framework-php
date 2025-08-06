<?php

namespace EyoPHP\Framework\Core;

use EyoPHP\Framework\Middleware\MiddlewareManager;

/**
 * Router - Système de routage avec support des paramètres dynamiques
 *
 * Supporte les routes avec paramètres comme /user/{id} ou /post/{slug}
 *
 * @package EyoPHP\Framework\Core
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */
class Router
{
    /**
     * @var array Liste des routes enregistrées
     */
    private array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    /**
     * Ajouter une route au routeur
     *
     * @param string $method HTTP method (GET, POST, PUT, DELETE)
     * @param string $path Route path with optional parameters (e.g., /user/{id})
     * @param string $controller Controller class name
     * @param string $action Controller method name
     * @param array $middlewares Optional middlewares for this route
     */
    public function addRoute(string $method, string $path, string $controller, string $action, array $middlewares = []): void
    {
        $route = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action,
            'pattern' => $this->compilePattern($path),
            'middlewares' => $middlewares
        ];

        $this->routes[] = $route;

        // Enregistrer automatiquement les middlewares de route
        foreach ($middlewares as $middleware) {
            MiddlewareManager::addToRoute($path, $middleware);
        }
    }

    /**
     * Compiler un pattern de route en regex
     *
     * Convertit /user/{id} en ^/user/([^/]+)$
     *
     * @param string $path Route path
     * @return string Compiled regex pattern
     */
    private function compilePattern(string $path): string
    {
        // Remplacer directement {param} par un groupe de capture
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $path);

        // Échapper les caractères spéciaux restants
        $pattern = str_replace('/', '\/', $pattern);

        // Ancrer le pattern
        return '/^' . $pattern . '$/';
    }

    /**
     * Extraire les noms des paramètres d'une route
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
     * Trouver le handler pour une requête
     *
     * @param string $method HTTP method
     * @param string $uri Request URI
     * @return array|false Route handler with parameters or false if not found
     */
    public function getHandler(string $method, string $uri)
    {
        foreach ($this->routes as $route) {
            // Vérifier la méthode HTTP
            if ($route['method'] !== $method) {
                continue;
            }

            // Tester le pattern
            if (preg_match($route['pattern'], $uri, $matches)) {
                // Supprimer le premier élément (match complet)
                array_shift($matches);

                // Extraire les noms des paramètres
                $paramNames = $this->extractParameterNames($route['path']);

                // Créer un tableau associatif des paramètres
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
     * Obtenir toutes les routes enregistrées
     *
     * @return array All registered routes
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Générer une URL à partir d'un nom de route et de paramètres
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
     * Ajouter une route publique (sans protection)
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
     * Ajouter une route pour utilisateurs connectés
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
     * Ajouter une route pour administrateurs uniquement
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
