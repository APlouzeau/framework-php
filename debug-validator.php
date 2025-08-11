<?php
require_once 'bootstrap.php';

use EyoPHP\Framework\Validation\Validator;

echo "<h1>🔧 Test Debug Validator</h1>";

// Test simple d'email invalide
$data = ['email' => 'invalid-email'];
$rules = ['email' => [['required'], ['email']]];

echo "<p><strong>Test simple:</strong></p>";
echo "<p>Email: {$data['email']}</p>";

$result = Validator::validateForm($data, $rules);

echo "<p><strong>Résultat complet:</strong></p>";
var_dump($result);

echo "<p><strong>Type de 'valid':</strong></p>";
var_dump($result['valid']);
var_dump(gettype($result['valid']));

echo "<p><strong>Test boolean:</strong></p>";
echo "Is true: " . ($result['valid'] === true ? 'OUI' : 'NON') . "<br>";
echo "Is false: " . ($result['valid'] === false ? 'OUI' : 'NON') . "<br>";
echo "Is empty: " . (empty($result['valid']) ? 'OUI' : 'NON') . "<br>";
