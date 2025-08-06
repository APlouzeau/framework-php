# Installation via Composer

Pour installer le framework EyoPHP dans votre projet :

```bash
composer require aplouzeau/eyophp-framework
```

## Utilisation rapide

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
