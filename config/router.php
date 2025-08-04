<?php

// Connexion
$router->addRoute('GET', BASE_URL, 'ControllerAppPages', 'loginPage');
$router->addRoute('GET', BASE_URL . 'loginPage', 'ControllerAppPages', 'loginPage');
$router->addRoute('GET', BASE_URL . 'profilPage', 'ControllerAppPages', 'profilPage');
$router->addRoute('GET', BASE_URL . 'logout', 'ControllerUser', 'disconnect');
$router->addRoute('GET', BASE_URL . 'registerPage', 'ControllerUser', 'registerPage');
$router->addRoute('POST', BASE_URL . 'register', 'ControllerUser', 'register');

// Navigation
$router->addRoute('GET', BASE_URL . "homePage", 'ControllerAppPages', 'homePage');
