<?php

/**
 * Exemple d'utilisation du framework EyoPHP
 * 
 * Ce fichier montre comment utiliser le framework en tant que package Composer
 */

require_once 'vendor/autoload.php';

use EyoPHP\Framework\Framework;
use EyoPHP\Framework\Core\Router;

// Initialiser le framework
Framework::init();

echo "EyoPHP Framework v" . Framework::version() . " initialisé !\n";

// Exemple d'utilisation du routeur
$router = new Router();

// Ajouter quelques routes d'exemple
$router->addRoute('GET', '/', 'HomeController', 'index');
$router->addRoute('GET', '/users', 'UserController', 'list');
$router->addRoute('GET', '/users/{id}', 'UserController', 'show');
$router->addRoute('POST', '/users', 'UserController', 'create');

// Simuler quelques requêtes
$testRoutes = [
    ['GET', '/'],
    ['GET', '/users'],
    ['GET', '/users/123'],
    ['POST', '/users'],
    ['GET', '/nonexistent']
];

echo "\nTest des routes :\n";
echo str_repeat('-', 50) . "\n";

foreach ($testRoutes as [$method, $uri]) {
    $handler = $router->getHandler($method, $uri);

    if ($handler) {
        printf(
            "✅ %s %s -> %s@%s\n",
            $method,
            $uri,
            $handler['controller'],
            $handler['action']
        );

        // Afficher les paramètres s'il y en a
        if (!empty($handler['params'])) {
            printf("   Paramètres: %s\n", json_encode($handler['params']));
        }
    } else {
        printf("❌ %s %s -> Route non trouvée\n", $method, $uri);
    }
}

echo "\n🎉 Framework prêt à être utilisé !\n";
