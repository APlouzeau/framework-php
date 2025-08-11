<?php
// Test de validation simple
require_once 'bootstrap.php';

echo "<h1>🧪 Test de validation EyoPHP</h1>";

use EyoPHP\Framework\Validation\Validator;

// Test 1: validateForm avec la structure de AuthController
echo "<h2>Test 1: validateForm</h2>";

$data = [
    'nickName' => 'test',
    'email' => 'invalid-email',
    'password' => '123',
    'confirmPassword' => '456'
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

echo "<p><strong>Données de test:</strong></p>";
echo "<pre>" . print_r($data, true) . "</pre>";

echo "<p><strong>Règles de validation:</strong></p>";
echo "<pre>" . print_r($rules, true) . "</pre>";

try {
    $result = Validator::validateForm($data, $rules);

    echo "<p><strong>Résultat:</strong></p>";
    echo "<pre>" . print_r($result, true) . "</pre>";

    if ($result['valid']) {
        echo "<p style='color: green;'>✅ Validation réussie</p>";
    } else {
        echo "<p style='color: red;'>❌ Erreurs de validation:</p>";
        foreach ($result['errors'] as $field => $errors) {
            echo "<ul>";
            foreach ($errors as $error) {
                echo "<li><strong>$field:</strong> $error</li>";
            }
            echo "</ul>";
        }
    }
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>Erreur PHP:</strong> " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<h2>Fin du test</h2>";
