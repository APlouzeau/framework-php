<?php
require_once 'bootstrap.php';

use EyoPHP\Framework\Validation\Validator;

echo "<h1>🧪 Test avec données VALIDES</h1>";

// Test avec données valides
$data = [
    'nickName' => 'utilisateur_test',
    'email' => 'test@example.com',
    'password' => 'MonMotDePasse123',
    'confirmPassword' => 'MonMotDePasse123'
];

$rules = [
    'nickName' => [
        ['required'],
    ],
    'email' => [
        ['required'],
        ['email'],
    ],
    'password' => [
        ['required'],
        ['password'],
        ['length', 8, 20]
    ],
    'confirmPassword' => [
        ['required'],
        ['match', 'password'],
    ],
];

echo "<p><strong>Données de test (VALIDES):</strong></p>";
echo "<pre>" . print_r($data, true) . "</pre>";

$result = Validator::validateForm($data, $rules);

echo "<p><strong>Résultat:</strong></p>";
var_dump($result);

if ($result['valid']) {
    echo "<p style='color: green;'>✅ VALIDATION RÉUSSIE !</p>";
} else {
    echo "<p style='color: red;'>❌ Validation échouée :</p>";
    foreach ($result['errors'] as $field => $errors) {
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li><strong>$field:</strong> $error</li>";
        }
        echo "</ul>";
    }
}
