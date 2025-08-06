# Documentation de votre application

Ce ## ⚙️ Configuration

Le fichier `phpdoc.xml.example` est pré-configuré pour :

-   ✅ **Documenter vos dossiers** `src/` et `app/`
-   ✅ **Inclure EyoPHP Framework** - Voir toutes les méthodes disponibles (Validator, User, Router, etc.)
-   ✅ **Exclure les autres packages** vendor/ (mais pas EyoPHP)
-   ✅ **Générer des graphiques** de classes
-   ✅ **Cache activé** pour des générations rapides

### 🎯 Pourquoi inclure EyoPHP Framework ?

Votre documentation contiendra aussi :

-   🔍 **Toutes les méthodes de validation** disponibles (`Validator::validateEmail()`, etc.)
-   👤 **Méthodes des entités** (`User::getNickname()`, `User::hasRole()`, etc.)
-   🛣️ **API du Router** pour vos routes personnalisées
-   📚 **Exemples d'utilisation** directement dans la doc contient les outils pour générer automatiquement la documentation de votre application.

## 🚀 Installation rapide

### 1. Copiez le fichier de configuration

```bash
cp docs-template/phpdoc.xml.example phpdoc.xml
```

### 2. Installez PHPDocumentor

```bash
composer require --dev phpdocumentor/shim
```

### 3. Générez votre documentation

```bash
# Via Composer
composer run docs

# Via PHPDocumentor directement
./vendor/bin/phpdoc -c phpdoc.xml

# Via Make (si vous avez un Makefile)
make docs
```

## 📁 Structure recommandée

```
votre-projet/
├── src/                    # Votre code source
├── app/                    # Vos contrôleurs/modèles
├── docs/
│   └── api/               # Documentation générée (ignorée par Git)
├── phpdoc.xml             # Configuration PHPDoc
└── composer.json
```

## ⚙️ Configuration

Le fichier `phpdoc.xml.example` est pré-configuré pour :

-   ✅ **Documenter vos dossiers** `src/` et `app/`
-   ✅ **Exclure EyoPHP Framework** de la documentation
-   ✅ **Exclure vendor/** (autres packages)
-   ✅ **Générer des graphiques** de classes
-   ✅ **Cache activé** pour des générations rapides

## 🎨 Personnalisation

### Ajouter des dossiers à documenter

```xml
<version number="1.0.0">
    <folder>src</folder>
    <folder>app</folder>
    <folder>mon-nouveau-dossier</folder>
</version>
```

### Changer le thème

```xml
<template name="clean"/>  <!-- ou "material", "responsive", etc. -->
```

### Modifier le titre

```xml
<title>Mon Super Projet - API Documentation</title>
```

## 📖 Scripts Composer suggérés

Ajoutez ces scripts à votre `composer.json` :

```json
{
    "scripts": {
        "docs": "phpdoc -c phpdoc.xml",
        "docs-serve": "php -S localhost:8080 -t docs/api",
        "docs-clean": "rm -rf docs/api .phpdoc"
    }
}
```

Puis utilisez :

```bash
composer docs        # Générer la doc
composer docs-serve  # Servir en local sur http://localhost:8080
composer docs-clean  # Nettoyer les fichiers générés
```

## 🔧 Makefile exemple

Si vous utilisez Make, voici un exemple de cibles :

```makefile
.PHONY: docs docs-serve docs-clean

docs:
	./vendor/bin/phpdoc -c phpdoc.xml

docs-serve: docs
	php -S localhost:8080 -t docs/api

docs-clean:
	rm -rf docs/api .phpdoc
```

## 📝 Bonnes pratiques de documentation

### Documentation de classe

```php
/**
 * Gestionnaire des utilisateurs
 *
 * Cette classe gère les opérations CRUD sur les utilisateurs
 * et leurs permissions dans l'application.
 *
 * @package MonApp\User
 * @author  Votre Nom
 * @version 1.0.0
 * @since   1.0.0
 */
class UserManager
{
    // ...
}
```

### Documentation de méthode

````php
/**
 * Crée un nouvel utilisateur
 *
 * @param string $email    L'email de l'utilisateur
 * @param string $password Le mot de passe (sera hashé)
 * @param array  $data     Données additionnelles optionnelles
 *
 * @return User L'utilisateur créé
 * @throws InvalidArgumentException Si l'email est invalide
 * @throws UserExistsException      Si l'utilisateur existe déjà
 *
 * @example
 * ```php
 * $user = $manager->createUser('john@doe.com', 'password123', [
 *     'name' => 'John Doe'
 * ]);
 * ```
 */
public function createUser(string $email, string $password, array $data = []): User
{
    // ...
}
````

---

**EyoPHP Framework** - Documentation automatique simplifiée !
