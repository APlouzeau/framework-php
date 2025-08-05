# EyoPHP Framework - Documentation API

## Classes principales

### ClassValidator

**Description :** Classe de validation des données avec méthodes statiques.

**Méthodes :**

#### `verifyEmail(string $email): array`
- **Description :** Valide une adresse email
- **Paramètres :** 
  - `$email` (string) : L'adresse email à valider
- **Retour :** array avec `['code' => 0|1, 'message' => 'string']`
- **Exemple :**
```php
$result = ClassValidator::verifyEmail('user@example.com');
if ($result['code']) {
    echo "Email valide !";
}
```

#### `verifyNickName(string $nickName): array`
- **Description :** Valide un pseudo utilisateur
- **Paramètres :** 
  - `$nickName` (string) : Le pseudo à valider (3-50 caractères)
- **Retour :** array avec `['code' => 0|1, 'message' => 'string']`

#### `verifyPassword(string $password): array`
- **Description :** Valide un mot de passe (longueur minimale)
- **Paramètres :** 
  - `$password` (string) : Le mot de passe à valider (6+ caractères)
- **Retour :** array avec `['code' => 0|1, 'message' => 'string']`

---

### TraitsPageRenderer

**Description :** Trait pour le rendu des pages avec layout commun.

**Méthodes :**

#### `generatePage(string $contentView, string $pageTitle, array $data = [], string $siteName = "My site"): void`
- **Description :** Génère une page complète avec header/footer
- **Paramètres :**
  - `$contentView` (string) : Chemin vers la vue principale
  - `$pageTitle` (string) : Titre de la page
  - `$data` (array) : Données à passer aux vues (optionnel)
  - `$siteName` (string) : Nom du site (optionnel)
- **Exemple :**
```php
$this->generatePage('/views/home.php', 'Accueil', ['user' => $userData]);
```

---

### ModelUser

**Description :** Modèle pour la gestion des utilisateurs (CRUD).

**Méthodes :**

#### `register(EntitieUser $user): bool`
- **Description :** Enregistre un nouvel utilisateur
- **Paramètres :** 
  - `$user` (EntitieUser) : L'entité utilisateur à enregistrer
- **Retour :** bool (true si succès, false sinon)

#### `login(EntitieUser $userVerify): EntitieUser|false`
- **Description :** Authentifie un utilisateur
- **Paramètres :** 
  - `$userVerify` (EntitieUser) : Données de connexion
- **Retour :** EntitieUser si succès, false sinon

#### `getAllUsers(): array`
- **Description :** Récupère tous les utilisateurs avec leurs rôles
- **Retour :** array d'objets EntitieUser

---

### EntitieUser

**Description :** Entité représentant un utilisateur.

**Propriétés :**
- `id_user` (int) : Identifiant unique
- `nickname` (string) : Pseudo de l'utilisateur
- `mail` (string) : Adresse email
- `password` (string) : Mot de passe hashé
- `id_role` (int) : Identifiant du rôle
- `created_at` (string) : Date de création
- `updated_at` (string) : Date de modification

**Méthodes principales :**
- `getId_user(): ?int`
- `getNickname(): ?string`
- `getMail(): ?string`
- `getId_role(): ?int`
- `hasRoleId(int $roleId): bool`
- `isAdmin(): bool`
- `isModerator(): bool`

---

## Architecture MVC

```
framework-php/
├── class/              # Classes utilitaires
│   ├── ClassValidator.php  # Validation des données
│   ├── ClassDatabase.php   # Connexion base de données
│   └── ClassRouter.php     # Routage des URLs
├── controller/         # Contrôleurs MVC
│   ├── ControllerAppPages.php    # Pages principales
│   ├── ControllerUserLogin.php   # Authentification
│   └── ControllerError.php       # Gestion d'erreurs
├── model/              # Modèles de données
│   ├── ModelUser.php       # Gestion utilisateurs
│   └── EntitieUser.php     # Entité utilisateur
├── views/              # Vues/Templates
│   ├── head.php, header.php, footer.php  # Layout
│   ├── home.php, login.php, register.php # Pages
│   └── profile.php, listUsers.php        # Utilisateurs
└── traits/             # Traits réutilisables
    └── TraitsPageRenderer.php # Rendu de pages
```

## Usage

### Démarrage rapide
```bash
make setup          # Installation complète
make setup-db        # Base de données
make serve           # Serveur de développement
make test            # Tests unitaires
```

### Validation des données
```php
// Validation email
$result = ClassValidator::verifyEmail($email);
if (!$result['code']) {
    echo $result['message']; // Message d'erreur
}

// Validation multiple
$errors = ClassValidator::verifyMultiple([
    'email' => $email,
    'nickname' => $nickname,
    'password' => $password
]);
```

### Gestion des utilisateurs
```php
// Créer un utilisateur
$user = new EntitieUser([
    'nickname' => 'john_doe',
    'mail' => 'john@example.com',
    'password' => 'password123',
    'id_role' => 1
]);

$modelUser = new ModelUser();
$success = $modelUser->register($user);

// Connexion
$loginUser = new EntitieUser(['nickname' => 'john_doe', 'password' => 'password123']);
$authenticatedUser = $modelUser->login($loginUser);
```

### Rendu de pages
```php
class MonController 
{
    use TraitsPageRenderer;
    
    public function maPage() 
    {
        $data = ['title' => 'Ma Page', 'content' => 'Contenu...'];
        $this->generatePage('/views/ma-page.php', 'Mon Titre', $data);
    }
}
```
