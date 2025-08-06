<?php

/**
 * Configuration des middlewares
 *
 * Ce fichier configure les middlewares globaux et par route
 */

use EyoPHP\Framework\Middleware\MiddlewareManager;

// Middlewares globaux (s'exécutent sur toutes les routes)
// Note: Les middlewares ci-dessous doivent encore être convertis en PSR-4
// MiddlewareManager::addGlobal('ClassMiddlewareLogging');
// MiddlewareManager::addGlobal('ClassMiddlewareCors');

// Middlewares par route - Protection des pages qui nécessitent une connexion
// Décommentez selon vos besoins :

// Protéger la page d'accueil
// MiddlewareManager::addToRoute('/accueil', 'ClassMiddlewareAuth');

// Protéger les pages de profil
// MiddlewareManager::addToRoute('/profil', 'ClassMiddlewareAuth');
// MiddlewareManager::addToRoute('/profile', 'ClassMiddlewareAuth');

// Protéger la liste des utilisateurs
// MiddlewareManager::addToRoute('/utilisateurs', 'ClassMiddlewareAuth');
// MiddlewareManager::addToRoute('/users', 'ClassMiddlewareAuth');

// Note: Décommentez les lignes ci-dessus pour activer la protection par authentification
// Une fois les middlewares convertis en PSR-4, utilisez les nouveaux noms de classes
