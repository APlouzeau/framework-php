<?php

/**
 * EyoPHP Framework - Usage Example
 * 
 * This file demonstrates how to use the EyoPHP Framework
 * Run: php example.php
 */

echo "=== EyoPHP Framework - Usage Example ===\n\n";

try {
    require_once 'vendor/autoload.php';
    echo "✅ Autoloader loaded successfully\n";

    $framework = new EyoPHP\Framework\Framework();
    $framework::init();
    echo "✅ Framework initialized\n";

    echo "Version: " . $framework::version() . "\n";
    echo "Features: MVC, Router, Validation, Authentication\n";
    echo "\nQuick Setup Guide:\n";
    echo "• Edit config/config.php for database settings\n";
    echo "• Start server: php -S localhost:8000 -t public/\n";
    echo "• Visit: http://localhost:8000\n";
    echo "• Test pages: /about, /contact, /login\n\n";
    echo "🚀 EyoPHP Framework is ready to use!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
