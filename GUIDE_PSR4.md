# 📘 Guide PSR-4 et utilisation des classes PHP

## 🎯 **Règle d'OR : Comment savoir quoi utiliser ?**

### 1. **Méthodes STATIQUES** → `Classe::methode()`

Les méthodes **statiques** appartiennent à la **classe**, pas à une instance particulière.

```php
// ✅ STATIQUE - On utilise Classe::methode()
AppController::renderView('login', $data);
Validator::validateForm($data, $rules);
UserModel::findByEmail($email);

// ❌ ERREUR - Ne pas instancier pour du statique
$app = new AppController(); // ← Inutile !
$app->renderView('login', $data); // ← Ne marchera pas
```

**👀 Comment les reconnaître ?**

-   Dans la classe : `public static function renderView()`
-   Le mot-clé `static` est présent
-   Pas besoin de `$this` dans la méthode

### 2. **Méthodes d'INSTANCE** → `$objet->methode()`

Les méthodes **d'instance** ont besoin d'un objet créé avec `new`.

```php
// ✅ INSTANCE - On crée l'objet puis on appelle la méthode
$user = new User($data);           // Créer l'objet
$userModel = new UserModel();      // Créer l'objet
$result = $userModel->register($user); // Utiliser l'objet

// ❌ ERREUR - Appeler statiquement une méthode d'instance
UserModel::register($user); // ← Ne marchera pas !
```

**👀 Comment les reconnaître ?**

-   Dans la classe : `public function register()` (sans `static`)
-   Utilise `$this` dans la méthode
-   A besoin de données spécifiques à l'instance

## 🔍 **Exemples concrets dans votre framework**

### ✅ **STATIQUE** - Utilitaires globaux

```php
// AppController::renderView() - Rendu de vue global
AppController::renderView('register', [
    'title' => 'Register',
    'errors' => $errors
]);

// Validator::validateForm() - Validation globale
$validation = Validator::validateForm($data, $rules);
```

### ✅ **INSTANCE** - Objets avec état

```php
// User - Représente UN utilisateur spécifique
$user = new User([
    'nickName' => 'John',
    'email' => 'john@example.com'
]);

// UserModel - Gère LES opérations sur les utilisateurs
$userModel = new UserModel();
$result = $userModel->register($user);
$result = $userModel->findByEmail('john@example.com');
```

## 🚨 **Erreurs courantes à éviter**

### ❌ **Erreur 1** : Mélanger statique et instance

```php
// MAUVAIS
$userModel = new UserModel();
$result = UserModel::register($user); // ← Incohérent !

// CORRECT
$userModel = new UserModel();
$result = $userModel->register($user); // ← Cohérent !
```

### ❌ **Erreur 2** : Instancier pour du statique

```php
// MAUVAIS
$app = new AppController();
$app->renderView('login', $data); // ← Inutile !

// CORRECT
AppController::renderView('login', $data); // ← Direct !
```

### ❌ **Erreur 3** : Oublier `new` pour les instances

```php
// MAUVAIS
$user = User(['name' => 'John']); // ← Manque `new` !

// CORRECT
$user = new User(['name' => 'John']); // ← Avec `new` !
```

## 💡 **Conseils pratiques**

1. **Si la méthode utilise `$this`** → C'est une instance → Utilisez `new` puis `->methode()`
2. **Si la méthode est marquée `static`** → C'est statique → Utilisez `Classe::methode()`
3. **Si vous hésitez** → Regardez les exemples dans le code existant
4. **Les entités (User, Product...)** → Toujours des instances avec `new`
5. **Les utilitaires (Validator, Helper...)** → Souvent statiques avec `::`

## 🎯 **Résumé en une phrase**

-   **`new + ->`** pour les objets qui représentent quelque chose de spécifique
-   **`Classe::`** pour les outils globaux qui ne dépendent pas d'un objet particulier
