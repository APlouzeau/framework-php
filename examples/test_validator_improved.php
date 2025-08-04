<?php

require_once __DIR__ . '/../class/ClassValidator.php';

echo "=== Tests du validator amélioré ===\n";

// Test de la nouvelle validation de mot de passe strict
echo "\n--- Test mot de passe format ---\n";
$passwords = [
    'MotDePasse123!',  // Valide
    'motdepasse123!',  // Pas de majuscule
    'MOTDEPASSE123!',  // Pas de minuscule
    'MotDePasse!',     // Pas de chiffre
    'MotDePasse123',   // Pas de caractère spécial
    '123!',            // Trop court
];

foreach ($passwords as $password) {
    $result = ClassValidator::verifyPasswordFormat($password);
    echo "Password '$password': " . ($result['code'] ? 'VALID' : 'INVALID') . " - " . $result['message'] . "\n";
}

// Test des nouvelles méthodes
echo "\n--- Tests nouvelles méthodes ---\n";

$notEmptyResult = ClassValidator::verifyNotEmpty("", "nom");
echo "Champ vide: " . json_encode($notEmptyResult) . "\n";

$notEmptyResult = ClassValidator::verifyNotEmpty("John", "nom");
echo "Champ rempli: " . json_encode($notEmptyResult) . "\n";

$lengthResult = ClassValidator::verifyLength("abc", 5, 10, "description");
echo "Longueur insuffisante: " . json_encode($lengthResult) . "\n";

$lengthResult = ClassValidator::verifyLength("abcdefgh", 5, 10, "description");
echo "Longueur correcte: " . json_encode($lengthResult) . "\n";

// Test complet d'un formulaire d'inscription
echo "\n--- Test formulaire d'inscription complet ---\n";

$formData = [
    'email' => 'user@example.com',
    'nickname' => 'john123',
    'password' => 'MonMotDePasse123!',
    'confirm_password' => 'MonMotDePasse123!',
    'firstname' => 'John'
];

$validations = [
    'email' => ClassValidator::verifyEmail($formData['email']),
    'nickname' => ClassValidator::verifyNickName($formData['nickname']),
    'password_format' => ClassValidator::verifyPasswordFormat($formData['password']),
    'password_match' => ClassValidator::verifyMatch(
        $formData['password'], 
        $formData['confirm_password'], 
        'mot de passe'
    ),
    'firstname' => ClassValidator::verifyNotEmpty($formData['firstname'], 'prénom')
];

$globalResult = ClassValidator::validateMultiple($validations);
echo "Formulaire complet: " . json_encode($globalResult, JSON_PRETTY_PRINT) . "\n";
