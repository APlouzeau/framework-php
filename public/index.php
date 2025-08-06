<?php
/**
 * EyoPHP Framework - Point d'entrée principal (Version Fonctionnelle)
 */

// Load Composer autoloader first
require_once __DIR__ . '/../vendor/autoload.php';

define("APP_PATH", __DIR__ . "/../");
define("BASE_URL", "/");

// Load configuration (la session sera gérée par Framework::init())
require_once APP_PATH . "config/config.php";

$router = new \EyoPHP\Framework\Core\Router();

// Load routes configuration
require_once APP_PATH . "config/routes.php";

// Récupération des informations de la requête
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Serve static files (CSS, JS, docs) directly
if (preg_match('/\.(css|js|md|txt|json|html|png|jpg|gif|svg)$/', $uri)) {
    $file_path = APP_PATH . ltrim($uri, '/');
    if (file_exists($file_path)) {
        $extension = pathinfo($file_path, PATHINFO_EXTENSION);
        $mime_type = match ($extension) {
            'css' => 'text/css',
            'js' => 'application/javascript',
            'md' => 'text/markdown',
            'txt' => 'text/plain',
            'json' => 'application/json',
            'html' => 'text/html',
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            default => 'text/plain'
        };
        header('Content-Type: ' . $mime_type);
        echo file_get_contents($file_path);
        exit;
    }
}

$handler = $router->getHandler($method, $uri);

if ($handler && isset($handler['controller']) && class_exists($handler['controller'])) {
    $controller = new $handler['controller']();
    if (method_exists($controller, $handler['action'])) {
        // Passer les paramètres de route au contrôleur si disponibles
        $parameters = $handler['parameters'] ?? [];
        if (!empty($parameters)) {
            $controller->{$handler['action']}($parameters);
        } else {
            $controller->{$handler['action']}();
        }
    } else {
        // Action n'existe pas - 404
        $controller = new \EyoPHP\Framework\Controller\ErrorController();
        $controller->index($handler, $method, $uri);
    }
} else {
    // Aucun handler trouvé - 404
    $controller = new \EyoPHP\Framework\Controller\ErrorController();
    $controller->index(null, $method, $uri);
}
