<?php

/**
 * Exemple d'utilisation des nouvelles classes PSR-4 du framework EyoPHP
 */

require_once 'vendor/autoload.php';

use EyoPHP\Framework\Framework;
use EyoPHP\Framework\Core\Router;
use EyoPHP\Framework\Entity\User;
use EyoPHP\Framework\Controller\ErrorController;

// Initialiser le framework
Framework::init();

echo "🚀 EyoPHP Framework v" . Framework::version() . " - Exemple des nouvelles classes PSR-4\n";
echo str_repeat('=', 70) . "\n\n";

// Test de l'entité User avec namespace
echo "📝 Test de l'entité User (EyoPHP\\Framework\\Entity\\User):\n";
echo str_repeat('-', 50) . "\n";

$userData = [
    'id_user' => 1,
    'nickname' => 'alexandra',
    'mail' => 'alexandra@example.com',
    'id_role' => 3, // admin
    'created_at' => date('Y-m-d H:i:s')
];

$user = new User($userData);

printf("✅ Utilisateur créé: %s (%s)\n", $user->getNickname(), $user->getMail());
printf("✅ Role ID: %d\n", $user->getId_role());
printf("✅ Est admin: %s\n", $user->isAdmin() ? 'Oui' : 'Non');
printf("✅ Est modérateur: %s\n", $user->isModerator() ? 'Oui' : 'Non');

echo "\n📊 Données utilisateur (toArray):\n";
print_r($user->toArray());

// Test de compatibilité avec l'alias
echo "\n🔄 Test de compatibilité avec l'alias (EntitieUser):\n";
echo str_repeat('-', 50) . "\n";

$legacyUser = new EntitieUser($userData);
printf("✅ Alias fonctionne: %s (%s)\n", $legacyUser->getNickname(), $legacyUser->getMail());
printf("✅ Même comportement: %s\n", $legacyUser->isAdmin() ? 'Oui' : 'Non');

// Test du routeur moderne
echo "\n🛣️  Test du routeur (EyoPHP\\Framework\\Core\\Router):\n";
echo str_repeat('-', 50) . "\n";

$router = new Router();
$router->addRoute('GET', '/api/users/{id}', 'ApiController', 'getUser');
$router->addRoute('POST', '/api/users', 'ApiController', 'createUser');

$testRoutes = [
    ['GET', '/api/users/123'],
    ['POST', '/api/users'],
    ['GET', '/api/unknown']
];

foreach ($testRoutes as [$method, $uri]) {
    $handler = $router->getHandler($method, $uri);

    if ($handler) {
        printf("✅ %s %s -> %s@%s", $method, $uri, $handler['controller'], $handler['action']);
        if (!empty($handler['params'])) {
            printf(" (params: %s)", json_encode($handler['params']));
        }
        echo "\n";
    } else {
        printf("❌ %s %s -> Route non trouvée\n", $method, $uri);
    }
}

// Test du contrôleur d'erreur
echo "\n🚨 Test du contrôleur d'erreur:\n";
echo str_repeat('-', 50) . "\n";

$errorController = new ErrorController();
echo "✅ ErrorController instancié avec namespace EyoPHP\\Framework\\Controller\\ErrorController\n";

echo "\n✨ Migration PSR-4 terminée avec succès!\n";
echo "📦 Le framework est maintenant compatible Composer avec namespaces PSR-4\n";
echo "🔄 Rétrocompatibilité maintenue via les aliases\n";
