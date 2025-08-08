<?php

use EyoPHP\Framework\Core\Router;

// Route configuration with simplified controller names
$router = new Router();

// ====================================
// 🌐 PUBLIC ROUTES
// ====================================
// Authentication pages (accessible without login)
$router->addPublicRoute('GET', BASE_URL, 'AppController', 'homePage');
$router->addPublicRoute('GET', BASE_URL . 'connexion', 'AppController', 'loginPage');
$router->addPublicRoute('POST', BASE_URL . 'login', 'AuthController', 'login');
$router->addPublicRoute('GET', BASE_URL . 'inscription', 'AppController', 'registerPage');
$router->addPublicRoute('POST', BASE_URL . 'register', 'AuthController', 'register');

// Public pages (accessible to everyone)
$router->addPublicRoute('GET', BASE_URL . 'about', 'AppController', 'aboutPage');
$router->addPublicRoute('GET', BASE_URL . 'contact', 'AppController', 'contactPage');

// ====================================
// 👤 USER ROUTES
// ====================================
// User area (requires login)
$router->addUserRoute('GET', BASE_URL . 'home', 'AppController', 'homePage');
$router->addUserRoute('GET', BASE_URL . 'logout', 'AuthController', 'logout');

// ====================================
// ⚠️ ERROR HANDLING ROUTES
// ====================================
$router->addPublicRoute('GET', BASE_URL . 'error/404', 'ErrorController', 'notFound');
$router->addPublicRoute('GET', BASE_URL . 'error/403', 'ErrorController', 'forbidden');
$router->addPublicRoute('GET', BASE_URL . 'error/500', 'ErrorController', 'serverError');

// Retourner le router configuré
return $router;
