# 🗄️ Guide phpMyAdmin - EyoPHP Framework

## 🚀 **Accès rapide**

### URLs d'accès

-   **phpMyAdmin** : http://localhost:8081
-   **Application** : http://localhost:8000

### Credentials par défaut

-   **Serveur** : localhost
-   **Utilisateur** : root
-   **Mot de passe** : (celui défini lors de l'installation MariaDB)

## 📋 **Démarrage**

### Méthode 1 : Scripts automatiques

```bash
# Windows
start-phpmyadmin.bat

# PowerShell
./start-phpmyadmin.ps1
```

### Méthode 2 : Manuel

```bash
cd framework-php/phpmyadmin
php -S localhost:8081
```

## 🎯 **Utilisation avec EyoPHP**

### 1. **Base de données du framework**

-   **Nom** : `eyophp_framework`
-   **Tables** : `users`, `roles`, `sessions`

### 2. **Créer la structure**

```sql
-- Dans phpMyAdmin, onglet SQL :
source database/schema.sql

-- Ou coller le contenu du fichier database/schema.sql
```

### 3. **Tester l'inscription**

1. Aller sur http://localhost:8000/register
2. Créer un compte
3. Vérifier dans phpMyAdmin → `eyophp_framework` → `users`

### 4. **Utilisateur admin par défaut**

-   **Nickname** : admin
-   **Email** : admin@eyophp.com
-   **Password** : password

## 🔧 **Configuration avancée**

### Modifier la configuration

Fichier : `phpmyadmin/config.inc.php`

```php
// Changer la langue
$cfg['DefaultLang'] = 'fr';

// Modifier le thème
$cfg['ThemeDefault'] = 'pmahomme';

// Limites mémoire
$cfg['MemoryLimit'] = '512M';
```

### Ajouter un autre serveur

```php
$i++;
$cfg['Servers'][$i]['verbose'] = 'Production DB';
$cfg['Servers'][$i]['host'] = 'prod.example.com';
$cfg['Servers'][$i]['port'] = '3306';
$cfg['Servers'][$i]['auth_type'] = 'cookie';
```

## 🛠️ **Commandes utiles**

### Export de la base

1. Sélectionner `eyophp_framework`
2. Onglet "Exporter"
3. Format : SQL
4. Télécharger

### Import de données

1. Sélectionner la base
2. Onglet "Importer"
3. Choisir le fichier .sql
4. Exécuter

### Surveillance des requêtes

1. Onglet "État"
2. "Variables du serveur"
3. "Requêtes"

## 🚨 **Dépannage**

### Erreur de connexion

1. Vérifier que MariaDB est démarré
2. Vérifier les credentials
3. Tester : `mysql -u root -p`

### phpMyAdmin ne charge pas

1. Vérifier le port 8081 libre
2. Redémarrer le serveur PHP
3. Vérifier `config.inc.php`

### Base de données introuvable

1. Créer la base : `CREATE DATABASE eyophp_framework;`
2. Importer le schema : `source database/schema.sql`
