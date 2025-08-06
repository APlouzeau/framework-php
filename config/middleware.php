<?php

/**
 * Configuration des middlewares
 *
 * Ce fichier configure les middlewares globaux et par route
 */

// Middlewares globaux (s'exécutent sur toutes les routes)
ClassMiddlewareManager::addGlobal('ClassMiddlewareLogging');
ClassMiddlewareManager::addGlobal('ClassMiddlewareCors');

// Middlewares par route - Protection des pages qui nécessitent une connexion
// Décommentez selon vos besoins :

// Protéger la page d'accueil
// ClassMiddlewareManager::addToRoute('/accueil', 'ClassMiddlewareAuth');

// Protéger les pages de profil
// ClassMiddlewareManager::addToRoute('/profil', 'ClassMiddlewareAuth');
// ClassMiddlewareManager::addToRoute('/profile', 'ClassMiddlewareAuth');

// Protéger la liste des utilisateurs
// ClassMiddlewareManager::addToRoute('/utilisateurs', 'ClassMiddlewareAuth');
// ClassMiddlewareManager::addToRoute('/users', 'ClassMiddlewareAuth');

// Middlewares par route - Protection des pages qui nécessitent une connexion
// Protéger les pages de profil
// ClassMiddlewareManager::addToRoute('/profil', 'ClassMiddlewareAuth');
// ClassMiddlewareManager::addToRoute('/profile', 'ClassMiddlewareAuth');

// Protéger la liste des utilisateurs
// ClassMiddlewareManager::addToRoute('/utilisateurs', 'ClassMiddlewareAuth');
// ClassMiddlewareManager::addToRoute('/users', 'ClassMiddlewareAuth');

// Note: Décommentez les lignes ci-dessus pour activer la protection par authentification
