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
        preg_match("/^(Class|Controller|Model|Entitie)/", $class_name, $match);
        $dir = match ($match[0]) {
            'Class' => APP_PATH . "/class",
            'Controller' => APP_PATH . "/controller",
            'Model' => APP_PATH . "/model",
            'Entitie' => APP_PATH . "/model"
        };
        if (file_exists($dir . '/' . $class_name . '.php')) {
            require_once $dir . '/' . $class_name . '.php';
        } else {
            throw new ClassNotFoundException("Class not found: " . $class_name);
        }
    } catch (\Throwable $th) {
        var_dump($th, $class_name);
    }
});

$router = new ClassRouter();
// Load routes configuration - keeping simple require_once for clarity
require_once APP_PATH . "config/router.php";

//routes connection

//redirection
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$handler = $router->getHandler($method, $uri);
if (!class_exists($handler['controller']) || $handler['controller'] == 'ControllerError') {
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
