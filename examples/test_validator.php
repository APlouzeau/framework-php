<?php

/**
 * Exemple d'utilisation de ClassValidator corrigé
 */

require_once __DIR__ . '/../class/ClassValidator.php';

// Test des validations individuelles
echo "=== Tests individuels ===\n";

// Test email
$emailResult = ClassValidator::verifyEmail("test@example.com");
echo "Email valide: " . json_encode($emailResult) . "\n";

$emailResult = ClassValidator::verifyEmail("email-invalide");
echo "Email invalide: " . json_encode($emailResult) . "\n";

// Test nickname
$nicknameResult = ClassValidator::verifyNickName("user123");
echo "Nickname valide: " . json_encode($nicknameResult) . "\n";

$nicknameResult = ClassValidator::verifyNickName("u");
echo "Nickname trop court: " . json_encode($nicknameResult) . "\n";

// Test password
$passwordResult = ClassValidator::verifyPassword("motdepasse123");
echo "Password valide: " . json_encode($passwordResult) . "\n";

$passwordResult = ClassValidator::verifyPassword("123");
echo "Password trop court: " . json_encode($passwordResult) . "\n";

// Test match (confirmation)
$matchResult = ClassValidator::verifyMatch("password123", "password123", "mot de passe");
echo "Mots de passe identiques: " . json_encode($matchResult) . "\n";

$matchResult = ClassValidator::verifyMatch("password123", "password456", "mot de passe");
echo "Mots de passe différents: " . json_encode($matchResult) . "\n";

echo "\n=== Test de validation multiple ===\n";

// Simulation d'un formulaire d'inscription
$formData = [
    'email' => 'user@example.com',
    'nickname' => 'john123',
    'password' => 'monmotdepasse',
    'confirm_password' => 'monmotdepasse'
];

// Validation de chaque champ
$validations = [
    'email' => ClassValidator::verifyEmail($formData['email']),
    'nickname' => ClassValidator::verifyNickName($formData['nickname']),
    'password' => ClassValidator::verifyPassword($formData['password']),
    'password_match' => ClassValidator::verifyMatch(
        $formData['password'],
        $formData['confirm_password'],
        'mot de passe'
    )
];

// Validation globale
$globalResult = ClassValidator::validateMultiple($validations);
echo "Résultat global: " . json_encode($globalResult, JSON_PRETTY_PRINT) . "\n";

// Exemple avec des erreurs
echo "\n=== Test avec erreurs ===\n";

$formDataWithErrors = [
    'email' => 'email-invalide',
    'nickname' => 'a',
    'password' => '123',
    'confirm_password' => '456'
];

$validationsWithErrors = [
    'email' => ClassValidator::verifyEmail($formDataWithErrors['email']),
    'nickname' => ClassValidator::verifyNickName($formDataWithErrors['nickname']),
    'password' => ClassValidator::verifyPassword($formDataWithErrors['password']),
    'password_match' => ClassValidator::verifyMatch(
        $formDataWithErrors['password'],
        $formDataWithErrors['confirm_password'],
        'mot de passe'
    )
];

$globalResultWithErrors = ClassValidator::validateMultiple($validationsWithErrors);
echo "Résultat avec erreurs: " . json_encode($globalResultWithErrors, JSON_PRETTY_PRINT) . "\n";
