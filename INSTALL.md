# 🚀 EyoPHP Framework - Installation Guide

## Two Installation Modes

EyoPHP Framework provides two installation modes to match your specific needs:

### � Complete Mode (Recommended)

**Perfect for:**

-   Professional development projects
-   Learning best practices through examples
-   Teams wanting tested, reliable code
-   Comprehensive development environment

**What's included:**

-   ✅ Complete test suite with PHPUnit
-   ✅ Example tests showing professional patterns
-   ✅ Documentation generation tools (phpDocumentor)
-   ✅ Example usage file (`example.php`)
-   ✅ Development tools and utilities

**Installation:**

```bash
composer create-project eyo/fw-php my-project
# Choose option [1] when prompted
```

**Available commands:**

```bash
composer test                # Run all tests
composer test-coverage      # Generate coverage report
composer docs               # Generate API documentation
php example.php             # See framework examples
```

### ⚡ Minimal Mode

**Perfect for:**

-   Experienced developers with existing testing workflows
-   Quick prototyping and experimentation
-   Custom setups where you'll add your own tools
-   Minimal footprint installations

**What's included:**

-   ✅ Core framework files only
-   ✅ Optimized for custom development
-   ✅ Smaller footprint
-   ⚠️ You'll need to add your own test suite

**Installation:**

```bash
composer create-project eyo/fw-php my-project
# Choose option [2] when prompted
```

```php
<?php

require_once 'vendor/autoload.php';

use EyoPHP\Framework\Framework;
use EyoPHP\Framework\Core\Router;

// Initialiser le framework
Framework::init();

// Créer le routeur
$router = new Router();

// Ajouter des routes
$router->addRoute('GET', '/', 'HomeController', 'index');
$router->addRoute('GET', '/users/{id}', 'UserController', 'show');

// Traiter la requête
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$handler = $router->getHandler($method, $uri);
if ($handler) {
    // Votre logique de traitement des routes
    echo "Route trouvée: " . $handler['controller'] . '@' . $handler['action'];
} else {
    http_response_code(404);
    echo "Page non trouvée";
}
```

## Structure du projet

Le framework EyoPHP utilise la structure PSR-4 :

-   `src/Core/` - Classes principales (Router, Database)
-   `src/Middleware/` - Middlewares
-   `src/Validation/` - Système de validation

## Configuration

Créez un fichier `.env` à la racine de votre projet :

```env
DB_HOST=localhost
DB_NAME=votre_base
DB_USER=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe
```

## Classes disponibles

### ✨ Nouvelles classes PSR-4 (Recommandées)

#### Core

-   `EyoPHP\Framework\Core\Router` - Routeur avec support des paramètres dynamiques
-   `EyoPHP\Framework\Core\Database` - Gestionnaire de base de données PDO (singleton)
-   `EyoPHP\Framework\Core\LegacyDatabase` - Version compatible avec l'ancien code

#### Entity

-   `EyoPHP\Framework\Entity\User` - Entité utilisateur moderne

#### Model

-   `EyoPHP\Framework\Model\UserModel` - Modèle de gestion des utilisateurs

#### Controller

-   `EyoPHP\Framework\Controller\ErrorController` - Gestionnaire d'erreurs

#### Middleware

-   `EyoPHP\Framework\Middleware\MiddlewareManager` - Gestionnaire de middleware
-   `EyoPHP\Framework\Middleware\AdminMiddleware` - Middleware d'administration
-   `EyoPHP\Framework\Middleware\UserMiddleware` - Middleware utilisateur

#### Validation

-   `EyoPHP\Framework\Validation\Validator` - Système de validation des données

#### Exception

-   `EyoPHP\Framework\Exception\ClassNotFoundException` - Exception personnalisée

### 🔄 Classes legacy (Rétrocompatibilité)

Ces classes utilisent les aliases automatiques vers les nouvelles classes PSR-4 :

-   `EntitieUser` → `EyoPHP\Framework\Entity\User`
-   `ModelUser` → `EyoPHP\Framework\Model\UserModel`
-   `ControllerError` → `EyoPHP\Framework\Controller\ErrorController`
-   `ClassDatabase` → `EyoPHP\Framework\Core\LegacyDatabase`
-   `ClassNotFoundException` → `EyoPHP\Framework\Exception\ClassNotFoundException`

### 💡 Exemple de migration

```php
// ❌ Ancienne façon (toujours supportée)
$user = new EntitieUser();
$model = new ModelUser();

// ✅ Nouvelle façon (recommandée)
use EyoPHP\Framework\Entity\User;
use EyoPHP\Framework\Model\UserModel;

$user = new User();
$model = new UserModel();
```
