<?php

use EyoPHP\Framework\Core\Router;

// Configuration des routes avec le système à 3 niveaux
$router = new Router();

// ====================================
// 🌐 ROUTES PUBLIQUES
// ====================================
// Pages d'authentification (accessibles sans connexion)
$router->addPublicRoute('GET', BASE_URL, 'AppController', 'homePage');
$router->addPublicRoute('GET', BASE_URL . 'connexion', 'AppController', 'loginPage');
$router->addPublicRoute('POST', BASE_URL . 'login', 'AuthController', 'login');
$router->addPublicRoute('GET', BASE_URL . 'inscription', 'AppController', 'registerPage');
$router->addPublicRoute('POST', BASE_URL . 'register', 'AuthController', 'register');

// Pages vitrine (accessibles à tous)
$router->addPublicRoute('GET', BASE_URL . 'about', 'AppController', 'aboutPage');
$router->addPublicRoute('GET', BASE_URL . 'contact', 'AppController', 'contactPage');

// ====================================
// 👤 ROUTES UTILISATEURS
// ====================================
// Zone utilisateur (nécessite une connexion)
$router->addUserRoute('GET', BASE_URL . 'home', 'AppController', 'homePage');
$router->addUserRoute('GET', BASE_URL . 'logout', 'AuthController', 'logout');

// ====================================
//  ROUTES DE GESTION D'ERREURS
// ====================================
$router->addPublicRoute('GET', BASE_URL . 'error/404', 'ErrorController', 'notFound');
$router->addPublicRoute('GET', BASE_URL . 'error/403', 'ErrorController', 'forbidden');
$router->addPublicRoute('GET', BASE_URL . 'error/500', 'ErrorController', 'serverError');

// Retourner le router configuré
return $router;
