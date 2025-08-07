# 🚀 EyoPHP Framework

> A minimalist and pragmatic PHP framework to quickly start web projects, without the complexity of "over-engineered" solutions

[![Latest Version](https://img.shields.io/packagist/v/eyo/fw-php.svg)](https://packagist.org/packages/eyo/fw-php)
[![License](https://img.shields.io/packagist/l/eyo/fw-php.svg)](https://packagist.org/packages/eyo/fw-php)

## 📦 Installation

### Via Composer Create-Project (Recommended)

EyoPHP Framework offers two installation modes to fit your needs:

```bash
composer create-project eyo/fw-php my-project
```

After installation, you'll be prompted to choose:

#### � **Complete Mode (Recommended)**

-   Full framework with professional test suite
-   Example tests demonstrating best practices
-   Documentation generation tools
-   Perfect for professional development and learning
-   Tested, production-ready code examples

#### ⚡ **Minimal Mode**

-   Framework core only for experienced developers
-   No example tests or documentation tools
-   Smaller footprint for quick prototyping
-   You'll add your own comprehensive test suite

### Via Composer Require (Library Mode)

```bash
composer require eyo/fw-php
```

### Basic Usage

```php
<?php
require_once 'vendor/autoload.php';

use EyoPHP\Framework\Framework;
use EyoPHP\Framework\Core\Router;

// Initialize the framework
Framework::init();

// Your application...
```

See [INSTALL.md](INSTALL.md) for detailed installation guide.

### Manual Installation

Clone this repository for development with the complete example:

## 🎯 Why EyoPHP?

**The absolute basics of a modern PHP website:**

-   ✅ **Functional homepage** right after installation
-   ✅ **Complete authentication system** (registration/login)
-   ✅ **Simple and readable router**
-   ✅ **Clear MVC structure** without excessive abstraction
-   ✅ **Ready-to-use database** with SQL script provided
-   ✅ **PSR-4 autoloading** and Composer support

**Philosophy: Keep it essential**

-   🎯 Pure PHP, no "black magic"
-   ⚡ Up and running in 5 minutes
-   🧠 Code you master 100%
-   🎓 Perfect for learning or teaching web basics
-   📦 **Now installable via Composer**

>```bash
git clone https://github.com/APlouzeau/framework-php.git my-project
cd my-project
composer install
```

## ⚙️ Configuration

**Important:** EyoPHP uses **phpdotenv** for environment management.

```bash
# Copy configuration file
cp .env.example .env

# Edit .env with your parameters
DB_HOST=localhost
DB_NAME=my_project
DB_USER=root
DB_PSW=password
```

> **Note:** Never commit your `.env` file to version control. The `.env.example` provides a template.

### Install dependencies

```bash
# With Makefile (recommended)
make install

# Manual
composer install
```

### Import database

```bash
# Create database and import schema
mysql -u root -p < database/users.sql
```

### Bootstrap the framework

```php
<?php
// In your main index.php or bootstrap file
require_once 'vendor/autoload.php'; // Composer autoloader
require_once 'bootstrap.php';       // EyoPHP bootstrap

// Or if installed via Composer
require_once 'vendor/aplouzeau/eyophp-framework/bootstrap.php';
```

### 5a. Start server (Development - Quick)

```bash
# With Makefile (recommended)
make serve

# Manual
php -S localhost:8000 -t public/
```

### 5b. Production server setup (Apache/Nginx)

<details>
<summary>Click to expand server configuration</summary>

**Apache Virtual Host:**

```apache
<VirtualHost *:80>
    ServerName my-project.local
    DocumentRoot /path/to/my-project/public

    <Directory /path/to/my-project/public>
        AllowOverride All
        Require all granted
        DirectoryIndex index.php
    </Directory>

    # Optional: Enable rewrite module for clean URLs
    RewriteEngine On
</VirtualHost>
```

**.htaccess file** (create in `public/.htaccess`):

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

**Nginx configuration:**

```nginx
server {
    listen 80;
    server_name my-project.local;
    root /path/to/my-project/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Security: deny access to sensitive files
    location ~ /\.(env|git) {
        deny all;
    }
}
```

**Don't forget:**

-   Add `127.0.0.1 my-project.local` to your `/etc/hosts` file (Linux/Mac) or `C:\Windows\System32\drivers\etc\hosts` (Windows)
-   Restart your web server after configuration changes
-   Ensure PHP modules are enabled: `mod_rewrite` (Apache) or `php-fpm` (Nginx)

</details>

### 6. You're all set! 🎉

**Access your application:**

-   **Development server:** `http://localhost:8000`
-   **Apache/Nginx server:** `http://my-project.local` (after virtual host setup)

**You now have:**

-   A homepage
-   A registration form (`/inscription` or `/register`)
-   A login form (`/connexion` or `/login`)
-   Ready-to-use test accounts (admin/admin123, moderator/mod123, testuser/user123)

## 🧪 Testing (Simple)

EyoPHP includes **PHPUnit** avec un exemple simple pour s'assurer que les validations fonctionnent.

### Lancer les tests

```bash
# Avec Makefile (recommandé)
make test

# Manuel
vendor/bin/phpunit
```

**Résultat:** 8 tests, 10 assertions ✅

### What's tested

-   ✅ Email validation (valid/invalid)
-   ✅ Username validation (length, characters)
-   ✅ Password validation (complexity)
-   ✅ Multiple validation (several fields)

**Test file:** `tests/Unit/SimpleValidationTest.php`

## 🔧 Makefile Commands

EyoPHP includes a **Makefile** to simplify common tasks:

```bash
make            # Show help
make install    # Install dependencies
make test       # Run tests
make serve      # Start development server
make clean      # Clean temporary files
make setup      # Complete installation
```

## 🏗️ Architecture

```
📁 config/          # Configuration & routing
├── config.php      # Environment variables
└── router.php      # Route definitions

📁 class/           # Utility classes
├── ClassRouter.php # Route handler
├── ClassDatabase.php # PDO connection
└── ClassValidator.php # Data validation

📁 controller/      # Business logic
├── ControllerAppPages.php # Main pages
└── ControllerUser.php     # User management

📁 model/           # Data access
├── ModelUser.php   # User SQL queries
└── EntitieUser.php # User entity

📁 views/           # PHP templates
├── head.php, header.php, footer.php # Layout
├── home.php        # Homepage
├── login.php       # Login form
└── register.php    # Registration form

📁 public/          # Web entry point
├── index.php       # Application bootstrap
├── styles.css      # Base CSS
└── script.js       # Base JS

📁 database/        # SQL scripts
└── users.sql       # Initial schema
```

## 📖 Usage Guide

### Using the Framework (v2.0+)

EyoPHP v2.0 now supports modern PHP with PSR-4 autoloading and namespaces:

```php
<?php
// Modern namespaced usage (recommended)
use EyoPHP\Framework\Core\Router;
use EyoPHP\Framework\Core\Database;
use EyoPHP\Framework\Validation\Validator;

// Initialize router
$router = new Router();

// Database singleton
$db = Database::getInstance();

// Validation
$result = Validator::validateEmail('test@example.com');
```

**Backward compatibility:** Old class names still work via aliases:

```php
<?php
// Legacy class names (still supported)
$router = new ClassRouter();
$db = new ClassDatabase();
$result = ClassValidator::validateEmail('test@example.com');
```

### Creating a new page

1. **Add the route** in `config/router.php`:

```php
$router->addRoute('GET', BASE_URL . 'my-page', 'ControllerMyController', 'myMethod');
```

2. **Create the controller** `controller/ControllerMyController.php`:

```php
<?php
class ControllerMyController {
    public function myMethod() {
        // Business logic
        require_once APP_PATH . "views/my-page.php";
    }
}
```

3. **Create the view** `views/my-page.php`:

```php
<?php require_once "head.php"; ?>
<?php require_once "header.php"; ?>

<h1>My new page</h1>
<p>Page content...</p>

<?php require_once "footer.php"; ?>
```

### Data validation

The built-in validation system makes form validation easy:

```php
// In your controller
$validator = new ClassValidator();
$errors = $validator->validate($_POST, [
    'nickname' => 'required|min:3|max:20',
    'email' => 'required|email',
    'password' => 'required|min:8'
]);

if (empty($errors)) {
    // Process valid data
} else {
    // Display errors
}
```

### Data access (no ORM)

The framework encourages using pure SQL for total control:

```php
// In a model
class ModelMyModel extends ClassDatabase {
    public function getUsers() {
        $stmt = $this->conn->prepare("
            SELECT u.id_user, u.nickname, u.mail, r.name as role_name
            FROM users u
            LEFT JOIN roles r ON u.id_role = r.id_role
            WHERE r.name = :role
            ORDER BY u.nickname ASC
        ");
        $stmt->bindValue(':role', 'user');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
```

## 🎯 Key Concepts

### 1. Naming convention (Smart autoloader)

-   `ControllerFoo` → `controller/ControllerFoo.php`
-   `ModelBar` → `model/ModelBar.php`
-   `ClassBaz` → `class/ClassBaz.php`
-   `EntitieUser` → `model/EntitieUser.php`

### 2. Simple and readable routing

```php
// config/router.php
$router->addRoute('GET', '/users', 'ControllerUser', 'list');
$router->addRoute('POST', '/users', 'ControllerUser', 'create');
$router->addRoute('GET', '/users/{id}', 'ControllerUser', 'show');
```

### 3. No ORM = SQL assumed

-   Total control over queries
-   Optimized performance
-   Easy debugging
-   Learning SQL fundamentals

## 🛠️ Included Features

-   ✅ **Autoloader** with naming conventions
-   ✅ **Router** with HTTP methods support
-   ✅ **Authentication system** (registration/login/logout)
-   ✅ **Data validation** with customizable rules
-   ✅ **Session management** built-in
-   ✅ **PHP templates** with modular layout
-   ✅ **Environment-based configuration** (phpdotenv)
-   ✅ **SQL scripts** for quick start
-   ✅ **PHPUnit testing** (simple validation tests)
-   ✅ **Makefile** for common tasks

## 🚧 Roadmap

-   [ ] **CLI installer** via Composer
-   [ ] **Code generators** (controller, model, etc.)
-   [ ] **Simple middleware system**
-   [ ] **File upload handling**
-   [ ] **Simple cache** (file/Redis)
-   [ ] **Structured logging**
-   [x] **Basic unit tests** ✅ (simple validation tests)

## 🎓 Educational Philosophy

EyoPHP is designed to:

-   **Understand** how a web framework works
-   **Learn** MVC patterns without abstraction
-   **Master** PHP and SQL rather than magic tools
-   **Quickly start** new projects

## 📦 Migration to bigger frameworks

EyoPHP code is intentionally close to standard PHP. Migrating to Symfony or Laravel will be easier after understanding the basics with EyoPHP.

## 🤝 Contributing

This framework is primarily intended for personal and educational use. Improvement suggestions are welcome!

## 📄 License

MIT License - Free to use for your personal and commercial projects.

---

> _"Simplicity is the ultimate sophistication"_ - Leonardo da Vinci
