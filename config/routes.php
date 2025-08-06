<?php

use EyoPHP\Framework\Core\Router;

// Configuration des routes avec le système à 3 niveaux
$router = new Router();

// ====================================
// 🌐 ROUTES PUBLIQUES
// ====================================
// Pages d'authentification (accessibles sans connexion)
$router->addPublicRoute('GET', BASE_URL, 'ControllerAppPages', 'loginPage');
$router->addPublicRoute('GET', BASE_URL . 'login', 'ControllerAppPages', 'loginPage');
$router->addPublicRoute('POST', BASE_URL . 'login', 'ControllerUserLogin', 'login');
$router->addPublicRoute('GET', BASE_URL . 'register', 'ControllerAppPages', 'registerPage');
$router->addPublicRoute('POST', BASE_URL . 'register', 'ControllerUserLogin', 'register');

// Pages vitrine (accessibles à tous)
$router->addPublicRoute('GET', BASE_URL . 'about', 'ControllerAppPages', 'aboutPage');
$router->addPublicRoute('GET', BASE_URL . 'contact', 'ControllerAppPages', 'contactPage');
$router->addPublicRoute('GET', BASE_URL . 'pricing', 'ControllerAppPages', 'pricingPage');

// ====================================
// 👤 ROUTES UTILISATEURS
// ====================================
// Zone utilisateur (nécessite une connexion)
$router->addUserRoute('GET', BASE_URL . 'home', 'ControllerAppPages', 'homePage');
$router->addUserRoute('GET', BASE_URL . 'dashboard', 'ControllerUser', 'dashboard');
$router->addUserRoute('GET', BASE_URL . 'profile', 'ControllerUser', 'profile');
$router->addUserRoute('POST', BASE_URL . 'profile/update', 'ControllerUser', 'updateProfile');
$router->addUserRoute('GET', BASE_URL . 'settings', 'ControllerUser', 'settings');
$router->addUserRoute('GET', BASE_URL . 'logout', 'ControllerUserLogin', 'logout');

// Fonctionnalités utilisateur
$router->addUserRoute('GET', BASE_URL . 'documents', 'ControllerDocument', 'list');
$router->addUserRoute('GET', BASE_URL . 'documents/{id}', 'ControllerDocument', 'view');
$router->addUserRoute('POST', BASE_URL . 'documents/upload', 'ControllerDocument', 'upload');

// ====================================
// 👑 ROUTES ADMINISTRATEURS
// ====================================
// Panel d'administration (nécessite le rôle admin)
$router->addAdminRoute('GET', BASE_URL . 'admin', 'ControllerAdmin', 'dashboard');
$router->addAdminRoute('GET', BASE_URL . 'admin/users', 'ControllerAdmin', 'listUsers');
$router->addAdminRoute('GET', BASE_URL . 'admin/users/{id}', 'ControllerAdmin', 'viewUser');
$router->addAdminRoute('POST', BASE_URL . 'admin/users/{id}/ban', 'ControllerAdmin', 'banUser');
$router->addAdminRoute('POST', BASE_URL . 'admin/users/{id}/unban', 'ControllerAdmin', 'unbanUser');
$router->addAdminRoute('DELETE', BASE_URL . 'admin/users/{id}', 'ControllerAdmin', 'deleteUser');

// Gestion système
$router->addAdminRoute('GET', BASE_URL . 'admin/settings', 'ControllerAdmin', 'settings');
$router->addAdminRoute('POST', BASE_URL . 'admin/settings/update', 'ControllerAdmin', 'updateSettings');
$router->addAdminRoute('GET', BASE_URL . 'admin/logs', 'ControllerAdmin', 'viewLogs');

// Statistiques
$router->addAdminRoute('GET', BASE_URL . 'admin/stats', 'ControllerAdmin', 'statistics');
$router->addAdminRoute('GET', BASE_URL . 'admin/reports', 'ControllerAdmin', 'reports');

// ====================================
// GESTION DES ERREURS
// ====================================
// Ces routes sont publiques car elles peuvent être atteintes depuis n'importe où
$router->addPublicRoute('GET', BASE_URL . 'error/404', 'EyoPHP\\Framework\\Controller\\ErrorController', 'notFound');
$router->addPublicRoute('GET', BASE_URL . 'error/403', 'EyoPHP\\Framework\\Controller\\ErrorController', 'forbidden');
$router->addPublicRoute('GET', BASE_URL . 'error/500', 'EyoPHP\\Framework\\Controller\\ErrorController', 'serverError');

// Retourner le router configuré
return $router;
