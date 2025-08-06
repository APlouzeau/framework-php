<?php

// ==============================================================
// EXEMPLE D'UTILISATION DU SYSTÈME À 3 NIVEAUX DE PERMISSIONS
// ==============================================================

echo "🔧 Démarrage du test du système de permissions...\n\n";

// Configuration de base
define('BASE_URL', '/');

// Simulation de différents types d'utilisateurs
function simulateUser($userId = null, $role = null)
{
    // Nettoyage session
    session_start();
    session_unset();

    if ($userId) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_role'] = $role;
        echo "👤 Utilisateur simulé : ID=$userId, Rôle=$role\n";
    } else {
        echo "🌐 Visiteur anonyme\n";
    }
}

require_once __DIR__ . '/config/routes.php';

echo "\n📋 Routes configurées :\n";
echo "==================\n";

// Test 1 : Visiteur anonyme
echo "\n🔍 TEST 1 : VISITEUR ANONYME\n";
echo "----------------------------\n";
simulateUser();

$testRoutes = [
    ['GET', '/'],
    ['GET', '/login'],
    ['GET', '/about'],
    ['GET', '/home'],           // Devrait échouer
    ['GET', '/admin'],          // Devrait échouer
];

foreach ($testRoutes as $test) {
    [$method, $path] = $test;

    try {
        $result = $router->getHandler($method, $path);
        if ($result) {
            echo "✅ $method $path : AUTORISÉ\n";
        }
    } catch (Exception $e) {
        echo "❌ $method $path : REFUSÉ - " . $e->getMessage() . "\n";
    }
}

// Test 2 : Utilisateur connecté
echo "\n🔍 TEST 2 : UTILISATEUR CONNECTÉ\n";
echo "--------------------------------\n";
simulateUser(123, 'user');

$testRoutes = [
    ['GET', '/'],
    ['GET', '/home'],           // Devrait marcher
    ['GET', '/profile'],        // Devrait marcher
    ['GET', '/admin'],          // Devrait échouer
    ['GET', '/admin/users'],    // Devrait échouer
];

foreach ($testRoutes as $test) {
    [$method, $path] = $test;

    try {
        $result = $router->getHandler($method, $path);
        if ($result) {
            echo "✅ $method $path : AUTORISÉ\n";
        }
    } catch (Exception $e) {
        echo "❌ $method $path : REFUSÉ - " . $e->getMessage() . "\n";
    }
}

// Test 3 : Administrateur
echo "\n🔍 TEST 3 : ADMINISTRATEUR\n";
echo "--------------------------\n";
simulateUser(456, 'admin');

$testRoutes = [
    ['GET', '/'],
    ['GET', '/home'],           // Devrait marcher (admin peut tout)
    ['GET', '/profile'],        // Devrait marcher
    ['GET', '/admin'],          // Devrait marcher
    ['GET', '/admin/users'],    // Devrait marcher
];

foreach ($testRoutes as $test) {
    [$method, $path] = $test;

    try {
        $result = $router->getHandler($method, $path);
        if ($result) {
            echo "✅ $method $path : AUTORISÉ\n";
        }
    } catch (Exception $e) {
        echo "❌ $method $path : REFUSÉ - " . $e->getMessage() . "\n";
    }
}

echo "\n🏁 Tests terminés !\n";
echo "\n📚 RÉSUMÉ DES RÈGLES :\n";
echo "=====================\n";
echo "🌐 ROUTES PUBLIQUES   : Accessibles à tous (même non connecté)\n";
echo "👤 ROUTES UTILISATEUR : Nécessitent d'être connecté (user OU admin)\n";
echo "👑 ROUTES ADMIN       : Nécessitent d'être connecté ET avoir le rôle 'admin'\n";
echo "\n💡 Les admins peuvent accéder aux routes utilisateur !\n";
echo "💡 Les routes publiques sont toujours accessibles !\n";
