<?php

use EyoPHP\Framework\Core\Router;

// Configuration des routes avec le système à 3 niveaux
$router = new Router();

// ====================================
// 🌐 ROUTES PUBLIQUES
// ====================================
// Pages d'authentification (accessibles sans connexion)
$router->addPublicRoute('GET', BASE_URL, 'EyoPHP\\Framework\\Controller\\AppController', 'homePage');
$router->addPublicRoute('GET', BASE_URL . 'connexion', 'EyoPHP\\Framework\\Controller\\AppController', 'loginPage');
$router->addPublicRoute('POST', BASE_URL . 'login', 'EyoPHP\\Framework\\Controller\\AuthController', 'login');
$router->addPublicRoute('GET', BASE_URL . 'inscription', 'EyoPHP\\Framework\\Controller\\AppController', 'registerPage');
$router->addPublicRoute('POST', BASE_URL . 'register', 'EyoPHP\\Framework\\Controller\\AuthController', 'register');

// Pages vitrine (accessibles à tous)
$router->addPublicRoute('GET', BASE_URL . 'about', 'EyoPHP\\Framework\\Controller\\AppController', 'aboutPage');
$router->addPublicRoute('GET', BASE_URL . 'contact', 'EyoPHP\\Framework\\Controller\\AppController', 'contactPage');
$router->addPublicRoute('GET', BASE_URL . 'pricing', 'EyoPHP\\Framework\\Controller\\AppController', 'pricingPage');

// ====================================
// 👤 ROUTES UTILISATEURS
// ====================================
// Zone utilisateur (nécessite une connexion)
$router->addUserRoute('GET', BASE_URL . 'home', 'EyoPHP\\Framework\\Controller\\AppController', 'homePage');
$router->addUserRoute('GET', BASE_URL . 'logout', 'EyoPHP\\Framework\\Controller\\AuthController', 'logout');

// ====================================
//  ROUTES DE GESTION D'ERREURS
// ====================================
$router->addPublicRoute('GET', BASE_URL . 'error/404', 'EyoPHP\\Framework\\Controller\\ErrorController', 'notFound');
$router->addPublicRoute('GET', BASE_URL . 'error/403', 'EyoPHP\\Framework\\Controller\\ErrorController', 'forbidden');
$router->addPublicRoute('GET', BASE_URL . 'error/500', 'EyoPHP\\Framework\\Controller\\ErrorController', 'serverError');

// Retourner le router configuré
return $router;
