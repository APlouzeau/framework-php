# EyoPHP Framework

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D8.1-blue.svg)](https://php.net/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![PSR-4](https://img.shields.io/badge/PSR--4-compliant-brightgreen.svg)](https://www.php-fig.org/psr/psr-4/)
[![Version](https://img.shields.io/badge/Version-0.1.0--experimental-orange.svg)](https://github.com/APlouzeau/framework-php/releases)

Un framework PHP éducatif moderne avec système de permissions, routing dynamique et middleware.

> ⚠️ **Version expérimentale** : Cette version 0.1.0 est en phase de test. Ne pas utiliser en production.

Un framework PHP éducatif moderne avec système de permissions, routing dynamique et middleware.

## 🚀 Installation

### Via Composer

```bash
composer require aplouzeau/eyophp-framework
```

### Installation manuelle

```bash
git clone https://github.com/APlouzeau/framework-php.git
cd framework-php
composer install
```

## 📋 Pré-requis

-   PHP 8.1 ou supérieur
-   Composer
-   Extensions PHP : PDO, PDO_MySQL (optionnel pour la base de données)

## 🎯 Utilisation de base

### Initialisation rapide

```php
<?php
require_once 'vendor/autoload.php';

use EyoPHP\Framework\Framework;
use EyoPHP\Framework\Core\Router;
use EyoPHP\Framework\Controller\ErrorController;

// Initialiser le framework
Framework::init();

// Créer un routeur
$router = new Router();

// Définir une route simple
$router->addRoute('GET', '/', 'HomeController', 'index');

// Traiter la requête
$router->run();
```

### Utilisation des entités

```php
use EyoPHP\Framework\Entity\User;

// Créer un utilisateur
$user = new User([
    'nickname' => 'johndoe',
    'mail' => 'john@example.com',
    'id_role' => 1
]);

// Accéder aux propriétés
echo $user->getNickname(); // johndoe
echo $user->getMail();     // john@example.com
```

### Validation des données

```php
use EyoPHP\Framework\Validation\Validator;

// Valider un email
$result = Validator::validateEmail('test@example.com');
if ($result['code'] === 1) {
    echo "Email valide !";
}

// Valider un mot de passe
$result = Validator::validatePasswordFormat('MonMotDePasse123!');
if ($result['code'] === 1) {
    echo "Mot de passe valide !";
}
```

### Middleware

```php
use EyoPHP\Framework\Middleware\MiddlewareManager;
use EyoPHP\Framework\Middleware\UserMiddleware;

// Ajouter un middleware global
MiddlewareManager::addGlobal(UserMiddleware::class);

// Ajouter un middleware à une route spécifique
MiddlewareManager::addToRoute('/admin', AdminMiddleware::class);
```

## 🏗️ Architecture

### Structure PSR-4

```
src/
├── Controller/          # Contrôleurs
│   └── ErrorController.php
├── Core/               # Classes principales
│   ├── Database.php
│   ├── LegacyDatabase.php
│   └── Router.php
├── Entity/             # Entités métier
│   └── User.php
├── Exception/          # Exceptions personnalisées
│   └── ClassNotFoundException.php
├── Middleware/         # Middlewares
│   ├── AdminMiddleware.php
│   ├── Middleware.php
│   ├── MiddlewareManager.php
│   └── UserMiddleware.php
├── Model/              # Modèles de données
│   └── UserModel.php
├── Validation/         # Validation des données
│   └── Validator.php
└── Framework.php       # Point d'entrée principal
```

### Namespace

Toutes les classes utilisent le namespace `EyoPHP\Framework\` suivi du sous-namespace approprié :

-   `EyoPHP\Framework\Entity\User`
-   `EyoPHP\Framework\Core\Router`
-   `EyoPHP\Framework\Validation\Validator`
-   etc.

## 🧪 Tests

```bash
# Lancer tous les tests
composer test

# Lancer les tests avec couverture
composer test-coverage

# Lancer un test spécifique
./vendor/bin/phpunit tests/Unit/UserEntityTest.php
```

## 📖 Documentation

### Documentation du framework

-   **Documentation en ligne** : [https://aplouzeau.github.io/framework-php/](https://aplouzeau.github.io/framework-php/)
-   **Code source** : Toutes les classes sont documentées avec PHPDoc

### Générer la documentation de votre application

Le framework inclut des outils pour générer automatiquement la documentation de **votre** application :

```bash
# 1. Configuration rapide
composer docs-setup

# 2. Installer PHPDocumentor
composer require --dev phpdocumentor/shim

# 3. Générer votre documentation
composer docs

# 4. Voir le résultat en local
composer docs-serve
# Ouvrez http://localhost:8080
```

**Avantages :**

-   ✅ Configuration pré-faite qui inclut les méthodes EyoPHP utiles
-   ✅ Voir toutes les fonctions de validation disponibles dans votre doc
-   ✅ Template Makefile inclus pour les utilisateurs avancés
-   ✅ Documentation combinée : VOTRE code + API du framework
-   ✅ Guide complet dans `docs-template/README.md`

# Lancer les tests avec couverture

composer test-coverage

# Lancer un test spécifique

./vendor/bin/phpunit tests/Unit/UserEntityTest.php

```

## 📚 Documentation complète

Pour une documentation détaillée, consultez :

-   [Guide d'installation](INSTALL.md)
-   [Guide des permissions](PERMISSIONS_GUIDE.md)
-   [Migration PSR-4](MIGRATION_PSR4.md)
-   [Documentation des tests](TESTING.md)

## 🤝 Contribution

1. Fork le projet
2. Créez une branche feature (`git checkout -b feature/ma-nouvelle-fonctionnalite`)
3. Commit vos changements (`git commit -am 'Ajout de ma nouvelle fonctionnalité'`)
4. Push sur la branche (`git push origin feature/ma-nouvelle-fonctionnalite`)
5. Ouvrez une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 📞 Support

-   **Issues** : [GitHub Issues](https://github.com/APlouzeau/framework-php/issues)
-   **Documentation** : [Wiki GitHub](https://github.com/APlouzeau/framework-php/wiki)
-   **Email** : alexandre.plouzeau@example.com

## 🏷️ Versions

-   **v2.0.0** : Migration complète vers PSR-4, architecture moderne
-   **v1.x** : Versions legacy avec ancien système de nommage

---

**EyoPHP Framework** - Un framework éducatif pour apprendre les bonnes pratiques PHP moderne.
```
