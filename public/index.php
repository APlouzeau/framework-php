<?php
#if (session_status() === PHP_SESSION_NONE) {
session_start();
#}

// Load Composer autoloader first
require_once __DIR__ . '/../vendor/autoload.php';

define("APP_PATH", __DIR__ . "/../");
define("BASE_URL", "/");

// Load custom exception before autoloader
require_once APP_PATH . "class/ClassNotFoundException.php";

// Note: We use require_once instead of PSR-4 namespaces for simplicity
// This makes the framework easier to understand for educational purposes
require_once APP_PATH . "config/config.php";

spl_autoload_register(function ($class_name) {
    try {
        preg_match("/^(Class|Controller|Model|Entitie|Traits)/", $class_name, $match);
        if (empty($match[0])) {
            throw new ClassNotFoundException("Invalid class name pattern: " . $class_name);
        }
        $dir = match ($match[0]) {
            'Class' => APP_PATH . "/class",
            'Controller' => APP_PATH . "/controller",
            'Model' => APP_PATH . "/model",
            'Entitie' => APP_PATH . "/model",
            'Traits' => APP_PATH . "/traits"
        };
        if (file_exists($dir . '/' . $class_name . '.php')) {
            require_once $dir . '/' . $class_name . '.php';
        } else {
            throw new ClassNotFoundException("Class not found: " . $class_name);
        }
    } catch (\Throwable $th) {
        // Silent error in production
        error_log("Autoloader error: " . $th->getMessage() . " for class: " . $class_name);
    }
});

$router = new ClassRouter();
// Load routes configuration - keeping simple require_once for clarity
require_once APP_PATH . "config/router.php";

//routes connection

//redirection
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
if (!$handler || !isset($handler['controller']) || !class_exists($handler['controller']) || $handler['controller'] == 'ControllerError') {
    $controller = new ControllerError();
    $controller->index($handler, $method, $uri);
} else {
    $controller = new $handler['controller']();
    if (!method_exists($controller, $handler['action'])) {
        $controller = new ControllerError();
        $controller->index($handler, $method, $uri);
    } else {
        $controller->{$handler['action']}();
    }
}
