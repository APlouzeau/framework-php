# 🔄 Guide de Migration PSR-4

Ce guide explique comment migrer du code existant vers la nouvelle structure PSR-4 du framework EyoPHP.

## 📋 Résumé de la migration

Le framework EyoPHP a été migré vers une structure PSR-4 moderne tout en maintenant la rétrocompatibilité avec l'ancienne structure.

### ✅ Avant (ancienne structure)

```
class/
├── ClassDatabase.php
├── ClassRouter.php
└── ...

controller/
├── ControllerError.php
└── ...

model/
├── EntitieUser.php
├── ModelUser.php
└── ...
```

### ✅ Après (nouvelle structure PSR-4)

```
src/
├── Core/
│   ├── Database.php
│   ├── LegacyDatabase.php
│   └── Router.php
├── Entity/
│   └── User.php
├── Model/
│   └── UserModel.php
├── Controller/
│   └── ErrorController.php
├── Exception/
│   └── ClassNotFoundException.php
└── aliases.php
```

## 🔄 Table de correspondance

| Ancienne classe          | Nouvelle classe PSR-4                               | Alias disponible |
| ------------------------ | --------------------------------------------------- | ---------------- |
| `EntitieUser`            | `EyoPHP\Framework\Entity\User`                      | ✅ Oui           |
| `ModelUser`              | `EyoPHP\Framework\Model\UserModel`                  | ✅ Oui           |
| `ControllerError`        | `EyoPHP\Framework\Controller\ErrorController`       | ✅ Oui           |
| `ClassDatabase`          | `EyoPHP\Framework\Core\LegacyDatabase`              | ✅ Oui           |
| `ClassRouter`            | `EyoPHP\Framework\Core\Router`                      | ✅ Oui           |
| `ClassNotFoundException` | `EyoPHP\Framework\Exception\ClassNotFoundException` | ✅ Oui           |

## 🛠️ Comment migrer votre code

### Option 1: Migration progressive (Recommandée)

Utilisez d'abord les alias, puis migrez progressivement vers les namespaces :

```php
// 1. Votre code existant continue de fonctionner
$user = new EntitieUser();
$model = new ModelUser();

// 2. Ajoutez progressivement les use statements
use EyoPHP\Framework\Entity\User;
use EyoPHP\Framework\Model\UserModel;

// 3. Remplacez les classes une par une
$user = new User();        // Au lieu de new EntitieUser()
$model = new UserModel();  // Au lieu de new ModelUser()
```

### Option 2: Migration complète

Remplacez tout d'un coup :

```php
<?php

// Ajoutez ces use statements au début de vos fichiers
use EyoPHP\Framework\Entity\User;
use EyoPHP\Framework\Model\UserModel;
use EyoPHP\Framework\Controller\ErrorController;
use EyoPHP\Framework\Core\Router;
use EyoPHP\Framework\Core\Database;

// Utilisez les nouvelles classes
$user = new User();
$model = new UserModel();
$router = new Router();
$db = Database::getInstance();
```

## 📦 Avantages de la migration

### ✅ PSR-4 Standard

-   Respect des standards PHP modernes
-   Meilleure organisation du code
-   Autoloading optimisé par Composer

### ✅ Namespaces

-   Évite les conflits de noms
-   Meilleure lisibilité du code
-   IDE plus intelligent (autocomplétion)

### ✅ Rétrocompatibilité

-   Code existant continue de fonctionner
-   Migration progressive possible
-   Pas de breaking changes

### ✅ Maintenance facilitée

-   Structure plus claire
-   Tests unitaires plus simples
-   Documentation automatique

## 🔧 Configuration requise

Votre `composer.json` doit inclure :

```json
{
    "autoload": {
        "psr-4": {
            "EyoPHP\\Framework\\": "src/"
        },
        "files": ["src/aliases.php"]
    }
}
```

## 🧪 Tests

Les tests fonctionnent avec les deux structures :

```bash
# Tests avec ancienne structure (via aliases)
./vendor/bin/phpunit tests/Unit/EntitieUserTest.php

# Tests avec nouvelle structure
./vendor/bin/phpunit tests/Unit/UserEntityTest.php

# Tous les tests
./vendor/bin/phpunit
```

## 🚀 Exemples

Voir les fichiers d'exemple :

-   `examples/composer-usage.php` - Utilisation basique
-   `examples/psr4-migration-demo.php` - Démonstration de la migration

## ⚡ Performance

La nouvelle structure PSR-4 offre :

-   Autoloading plus rapide
-   Moins de conflits de classes
-   Optimisation Composer activée
-   Cache d'autoloader plus efficace

## 🆘 Dépannage

### Classe non trouvée après migration

```bash
# Régénérez l'autoloader
composer dump-autoload
```

### Conflits de classes

Les aliases évitent automatiquement les conflits. Si vous rencontrez des problèmes :

1. Vérifiez que `src/aliases.php` est chargé
2. Utilisez directement les namespaces complets
3. Videz le cache d'autoloader : `composer dump-autoload --no-cache`

### Tests qui échouent

Assurez-vous d'avoir les bonnes dépendances :

```bash
composer install
composer dump-autoload
./vendor/bin/phpunit
```

## 📞 Support

-   Issues GitHub : [framework-php/issues](https://github.com/APlouzeau/framework-php/issues)
-   Documentation : `docs/README.md`
-   Exemples : `examples/`
