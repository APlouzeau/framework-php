# 🚀 Démarrage rapide EyoPHP Framework

## 📋 Prérequis

-   PHP 8.1+ avec PDO
-   MariaDB ou MySQL
-   Un navigateur web

## ⚡ Installation en 5 minutes

### 1. **Installer MariaDB**

```powershell
# Via Chocolatey (recommandé)
choco install mariadb -y

# Ou télécharger manuellement depuis
# https://mariadb.org/download/
```

### 2. **Configurer la base de données**

```sql
# Se connecter à MariaDB
mysql -u root -p

# Créer la base de données
source database/schema.sql

# Ou manuellement :
CREATE DATABASE eyophp_framework;
# Puis exécuter le contenu de database/schema.sql
```

### 3. **Configuration**

Le fichier `.env` est déjà configuré pour une installation locale standard :

```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=eyophp_framework
DB_USER=root
DB_PASSWORD=root
```

### 4. **Démarrer le serveur**

```bash
cd framework-php
php -S localhost:8000 -t public
```

### 5. **Accéder à l'application**

Ouvrir http://localhost:8000

## 🧪 Tester l'inscription

1. Aller sur http://localhost:8000/register
2. Créer un compte
3. Se connecter sur http://localhost:8000/login

## 📊 Accès à la base de données

### Avec phpMyAdmin (si installé)

-   URL : http://localhost/phpmyadmin
-   User : root
-   Password : root (ou votre mot de passe)

### En ligne de commande

```bash
mysql -u root -p eyophp_framework
```

## 🐳 Alternative Docker

Si vous préférez Docker :

```bash
docker-compose up -d
```

Puis accéder à :

-   Application : http://localhost:8080
-   phpMyAdmin : http://localhost:8081

## 🔧 Dépannage

### Erreur de connexion DB

1. Vérifier que MariaDB est démarré
2. Vérifier les credentials dans `.env`
3. Vérifier que la base `eyophp_framework` existe

### Erreur 404

1. Vérifier que vous êtes dans le bon dossier
2. Utiliser `-t public` avec le serveur PHP

### Erreur de validation

Les erreurs s'affichent directement dans le formulaire grâce au système de validation intégré.
