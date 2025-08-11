# 🔧 Installation manuelle Apache + MariaDB + phpMyAdmin

## 1. Apache (via Chocolatey ou manual)

### Via Chocolatey (recommandé)

```powershell
# Installer Chocolatey si pas encore fait
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))

# Installer Apache
choco install apache-httpd -y
```

### Configuration Apache pour EyoPHP

Fichier: `C:\tools\Apache24\conf\extra\httpd-vhosts.conf`

```apache
<VirtualHost *:80>
    ServerName eyophp.local
    DocumentRoot "C:/Users/Alexandre PLOUZEAU/Desktop/Projets/Qommute/Factures/framework-php/public"

    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ /index.php?url=$1 [QSA,L]

    <Directory "C:/Users/Alexandre PLOUZEAU/Desktop/Projets/Qommute/Factures/framework-php/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Activer les modules nécessaires

Fichier: `C:\tools\Apache24\conf\httpd.conf`

```apache
# Décommenter ces lignes
LoadModule rewrite_module modules/mod_rewrite.so
LoadModule headers_module modules/mod_headers.so
Include conf/extra/httpd-vhosts.conf
```

## 2. MariaDB

### Via Chocolatey

```powershell
choco install mariadb -y
```

### Configuration

```sql
-- Se connecter à MariaDB
mysql -u root -p

-- Créer la base et l'utilisateur
CREATE DATABASE eyophp_framework;
CREATE USER 'eyophp'@'localhost' IDENTIFIED BY 'eyophp123';
GRANT ALL PRIVILEGES ON eyophp_framework.* TO 'eyophp'@'localhost';
FLUSH PRIVILEGES;
```

## 3. phpMyAdmin

### Téléchargement

```powershell
# Télécharger depuis https://www.phpmyadmin.net/
# Extraire dans C:\tools\phpMyAdmin\
```

### Configuration

Fichier: `C:\tools\phpMyAdmin\config.inc.php`

```php
<?php
$cfg['Servers'][$i]['host'] = 'localhost';
$cfg['Servers'][$i]['port'] = '3306';
$cfg['Servers'][$i]['auth_type'] = 'cookie';
$cfg['blowfish_secret'] = 'un-secret-de-32-caracteres-minimum';
```

### VirtualHost pour phpMyAdmin

```apache
<VirtualHost *:80>
    ServerName phpmyadmin.local
    DocumentRoot "C:/tools/phpMyAdmin"

    <Directory "C:/tools/phpMyAdmin">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## 4. Fichier hosts

Ajouter dans `C:\Windows\System32\drivers\etc\hosts` :

```
127.0.0.1 eyophp.local
127.0.0.1 phpmyadmin.local
```

## 5. Démarrage des services

```powershell
# Démarrer Apache
net start Apache2.4

# Démarrer MariaDB
net start MySQL
```

## Accès

-   **Application** : http://eyophp.local
-   **phpMyAdmin** : http://phpmyadmin.local
