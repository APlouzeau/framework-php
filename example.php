<?php

/**
 * Exemple d'utilisation du framework EyoPHP
 * 
 * Ce fichier montre comment utiliser le framework comme package Composer
 */

require_once 'vendor/autoload.php';

use EyoPHP\Framework\Framework;
use EyoPHP\Framework\Entity\User;
use EyoPHP\Framework\Validation\Validator;
use EyoPHP\Framework\Core\Router;

// Initialiser le framework
Framework::init();

echo "=== EyoPHP Framework - Exemple d'utilisation ===\n\n";

// 1. Utilisation des entités
echo "1. Création d'un utilisateur :\n";
$user = new User([
    'id_user' => 1,
    'nickname' => 'johndoe',
    'mail' => 'john.doe@example.com',
    'id_role' => 1
]);

echo "Utilisateur créé : {$user->getNickname()} ({$user->getMail()})\n\n";

// 2. Validation des données
echo "2. Validation des données :\n";

$emailResult = Validator::validateEmail('test@example.com');
echo "Email 'test@example.com' : " . ($emailResult['code'] ? "✅ Valide" : "❌ Invalide") . "\n";

$emailResult = Validator::validateEmail('email-invalide');
echo "Email 'email-invalide' : " . ($emailResult['code'] ? "✅ Valide" : "❌ Invalide") . "\n";

$passwordResult = Validator::validatePasswordFormat('MotDePasse123!');
echo "Mot de passe 'MotDePasse123!' : " . ($passwordResult['code'] ? "✅ Valide" : "❌ Invalide") . "\n\n";

// 3. Information sur le framework
echo "3. Informations du framework :\n";
echo "Version : " . Framework::version() . "\n";

echo "\n=== Fin de l'exemple ===\n";
