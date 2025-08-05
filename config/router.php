<?php

// Configuration des routes EyoPHP
// Format: $router->addRoute('METHOD', 'URL', 'Controller', 'method');
// Note: URLs avec aliases français/anglais pour flexibilité

// Authentification
$router->addRoute('GET', BASE_URL, 'ControllerAppPages', 'loginPage');
$router->addRoute('GET', BASE_URL . 'connexion', 'ControllerAppPages', 'loginPage');
$router->addRoute('GET', BASE_URL . 'login', 'ControllerAppPages', 'loginPage'); // Alias anglais
$router->addRoute('POST', BASE_URL . 'connexion', 'ControllerUserLogin', 'login');
$router->addRoute('POST', BASE_URL . 'login', 'ControllerUserLogin', 'login'); // Alias anglais

$router->addRoute('GET', BASE_URL . 'inscription', 'ControllerAppPages', 'registerPage');
$router->addRoute('GET', BASE_URL . 'register', 'ControllerAppPages', 'registerPage'); // Alias anglais
$router->addRoute('POST', BASE_URL . 'inscription', 'ControllerUserLogin', 'register');
$router->addRoute('POST', BASE_URL . 'register', 'ControllerUserLogin', 'register'); // Alias anglais

$router->addRoute('GET', BASE_URL . 'deconnexion', 'ControllerUserLogin', 'logout');
$router->addRoute('GET', BASE_URL . 'logout', 'ControllerUserLogin', 'logout'); // Alias anglais

// Navigation
$router->addRoute('GET', BASE_URL . 'accueil', 'ControllerAppPages', 'homePage');
$router->addRoute('GET', BASE_URL . 'home', 'ControllerAppPages', 'homePage'); // Alias anglais
$router->addRoute('GET', BASE_URL . 'profil', 'ControllerAppPages', 'profilPage');
$router->addRoute('GET', BASE_URL . 'profile', 'ControllerAppPages', 'profilPage'); // Alias anglais
$router->addRoute('GET', BASE_URL . 'utilisateurs', 'ControllerAppPages', 'listUsersPage');
$router->addRoute('GET', BASE_URL . 'users', 'ControllerAppPages', 'listUsersPage'); // Alias anglais

// API/Actions
$router->addRoute('POST', BASE_URL . 'deleteUser', 'ControllerUserLogin', 'deleteUser');
