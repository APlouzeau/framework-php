# 🛡️ Système de Permissions à 3 Niveaux - EyoPHP Framework

## 📋 Vue d'ensemble

Le framework EyoPHP implémente un système de permissions à 3 niveaux qui permet de contrôler l'accès aux différentes parties de votre application :

-   🌐 **PUBLIC** : Accessible à tous (pages vitrine, connexion, inscription)
-   👤 **USER** : Accessible aux utilisateurs connectés (tableau de bord, profil)
-   👑 **ADMIN** : Accessible uniquement aux administrateurs (gestion utilisateurs, statistiques)

## 🔧 Configuration requise

### Sessions PHP

```php
// Dans votre système d'authentification
$_SESSION['user_id'] = $userId;        // ID de l'utilisateur connecté
$_SESSION['user_role'] = 'user';       // 'user' ou 'admin'
```

### Structure des fichiers

```
class/
├── ClassRouter.php                    // Router avec support middleware
├── ClassMiddleware.php                // Classe de base pour tous les middlewares
├── ClassMiddlewarePermissions.php     // Middlewares spécialisés User/Admin
└── ClassMiddlewareRole.php            // Middleware générique par rôle

config/
└── routes.php                         // Configuration des routes
```

## 🚀 Utilisation

### 1. Routes Publiques (🌐)

```php
// Accessible à tous, même non connecté
$router->addPublicRoute('GET', '/login', 'ControllerAuth', 'loginPage');
$router->addPublicRoute('POST', '/login', 'ControllerAuth', 'login');
$router->addPublicRoute('GET', '/about', 'ControllerApp', 'aboutPage');
```

### 2. Routes Utilisateur (👤)

```php
// Nécessite d'être connecté (user OU admin)
$router->addUserRoute('GET', '/home', 'ControllerUser', 'dashboard');
$router->addUserRoute('GET', '/profile', 'ControllerUser', 'profile');
$router->addUserRoute('GET', '/documents/{id}', 'ControllerDoc', 'view');
```

### 3. Routes Administrateur (👑)

```php
// Nécessite d'être connecté ET avoir le rôle 'admin'
$router->addAdminRoute('GET', '/admin', 'ControllerAdmin', 'dashboard');
$router->addAdminRoute('GET', '/admin/users', 'ControllerAdmin', 'listUsers');
$router->addAdminRoute('DELETE', '/admin/users/{id}', 'ControllerAdmin', 'deleteUser');
```

## 🛠️ Architecture technique

### ClassRouter - Méthodes de protection

```php
class ClassRouter {
    // Route publique (aucune protection)
    public function addPublicRoute($method, $path, $controller, $action) {
        $this->addRoute($method, $path, $controller, $action);
    }

    // Route utilisateur (middleware ClassMiddlewareUser)
    public function addUserRoute($method, $path, $controller, $action) {
        $this->addRoute($method, $path, $controller, $action, ['ClassMiddlewareUser']);
    }

    // Route admin (middleware ClassMiddlewareAdmin)
    public function addAdminRoute($method, $path, $controller, $action) {
        $this->addRoute($method, $path, $controller, $action, ['ClassMiddlewareAdmin']);
    }
}
```

### Middlewares de permissions

#### ClassMiddlewareUser

-   Vérifie que `$_SESSION['user_id']` existe
-   Accepte les rôles 'user' ET 'admin'
-   Redirige vers la page de connexion si non authentifié

#### ClassMiddlewareAdmin

-   Vérifie que `$_SESSION['user_id']` existe
-   Vérifie que `$_SESSION['user_role'] === 'admin'`
-   Retourne une erreur 403 si pas admin

## 📊 Matrice des permissions

| Type de route | Visiteur | User connecté | Admin |
| ------------- | -------- | ------------- | ----- |
| 🌐 PUBLIC     | ✅       | ✅            | ✅    |
| 👤 USER       | ❌       | ✅            | ✅    |
| 👑 ADMIN      | ❌       | ❌            | ✅    |

## 🔍 Exemple complet

```php
<?php
// config/routes.php

$router = new ClassRouter();

// === PAGES PUBLIQUES ===
$router->addPublicRoute('GET', '/', 'ControllerApp', 'home');
$router->addPublicRoute('GET', '/login', 'ControllerAuth', 'loginForm');
$router->addPublicRoute('POST', '/login', 'ControllerAuth', 'processLogin');

// === ESPACE UTILISATEUR ===
$router->addUserRoute('GET', '/dashboard', 'ControllerUser', 'dashboard');
$router->addUserRoute('GET', '/profile', 'ControllerUser', 'profile');
$router->addUserRoute('POST', '/profile/update', 'ControllerUser', 'updateProfile');

// === ADMINISTRATION ===
$router->addAdminRoute('GET', '/admin', 'ControllerAdmin', 'dashboard');
$router->addAdminRoute('GET', '/admin/users', 'ControllerAdmin', 'listUsers');
$router->addAdminRoute('POST', '/admin/users/{id}/ban', 'ControllerAdmin', 'banUser');

return $router;
```

## 🚨 Gestion des erreurs

Le système gère automatiquement les cas d'erreur :

-   **Non connecté** → Redirection vers `/login`
-   **Pas les permissions** → Erreur 403 Forbidden
-   **Route introuvable** → Erreur 404 Not Found

## 💡 Bonnes pratiques

### 1. Organisation des routes

```php
// Grouper par niveau de permission
// 🌐 PUBLIC d'abord
// 👤 USER ensuite
// 👑 ADMIN à la fin
```

### 2. Nommage cohérent

```php
// Utiliser des noms explicites
$router->addUserRoute('GET', '/user/settings', 'ControllerUser', 'settings');
$router->addAdminRoute('GET', '/admin/settings', 'ControllerAdmin', 'settings');
```

### 3. Paramètres dynamiques

```php
// Support des paramètres dans l'URL
$router->addUserRoute('GET', '/documents/{id}', 'ControllerDoc', 'view');
$router->addAdminRoute('GET', '/admin/users/{id}', 'ControllerAdmin', 'viewUser');
```

## 🔧 Tests

Utilisez le fichier `examples/test_permissions.php` pour vérifier que votre système fonctionne :

```bash
php examples/test_permissions.php
```

## 📈 Évolutions possibles

-   **Middleware custom** : Créer des middlewares spécifiques
-   **Rôles multiples** : Support de plusieurs rôles par utilisateur
-   **Permissions granulaires** : Système de permissions par ressource
-   **Cache des permissions** : Optimisation des vérifications répétées

---

_Framework EyoPHP v2.0 - Système de permissions professionnelles_
