# 🚀 EyoPHP Framework

> A minimalist PHP framework that gets you from zero to working web app in 5 minutes

[![Latest Version](https://img.shields.io/packagist/v/eyo/fw-php.svg)](https://packagist.org/packages/eyo/fw-php)
[![License](https://img.shields.io/packagist/l/eyo/fw-php.svg)](https://packagist.org/packages/eyo/fw-php)

> 🇫🇷 **Note for French learners**: This framework was created by a French developer for educational purposes. While documentation is in English for international reach, you'll find extensive French comments in the code and detailed French tutorials in the `/docs` folder.

## ⚡ Quick Start

Get a working web application in 2 commands:

```bash
# Choose your installation mode by project name:
composer create-project eyo/fw-php my-app-complete    # Full features
composer create-project eyo/fw-php my-app-minimal     # Lightweight
composer create-project eyo/fw-php my-app             # Interactive choice

cd my-app && php -S localhost:8000 -t public
```

Open [http://localhost:8000](http://localhost:8000) → You have a working app with authentication! 🎉

## 📦 Installation

### 🧠 Smart Installation (Auto-detects from project name)

**⚡ Minimal Mode** - Just add `-minimal` to your project name:

```bash
composer create-project eyo/fw-php blog-minimal
composer create-project eyo/fw-php api-minimal
composer create-project eyo/fw-php myapp-minimal
```

**📚 Complete Mode** - Add `-complete` to your project name:

```bash
composer create-project eyo/fw-php cms-complete
composer create-project eyo/fw-php website-complete
composer create-project eyo/fw-php myapp-complete
```

**🤔 Interactive Choice** - Use any other name:

```bash
composer create-project eyo/fw-php myproject
# Will ask you to choose between Complete/Minimal modes
```

### 🔧 Change Mode Later

```bash
cd myproject
php scripts/setup.php minimal    # Switch to minimal
php scripts/setup.php complete   # Switch to complete
```

### 🌍 Advanced: Environment Variables (Optional)

```bash
EYOPHP_MODE=minimal composer create-project eyo/fw-php my-project
EYOPHP_MODE=complete composer create-project eyo/fw-php my-project
```

### Alternative Installation Methods

**Option 2: Add to Existing Project**

```bash
composer require eyo/fw-php
```

**Option 3: Git Clone**

```bash
git clone https://github.com/APlouzeau/framework-php.git my-project
cd my-project
composer install
```

## ⚙️ Configuration

### 1. Environment Setup

```bash
# Copy the environment template
cp .env.example .env

# Edit your database credentials
# .env
DB_HOST=localhost
DB_NAME=my_project
DB_USER=root
DB_PSW=your_password
```

### 2. Database Setup

```bash
# Import the provided SQL schema
mysql -u root -p < database/users.sql
```

### 3. Start Development Server

```bash
php -S localhost:8000 -t public
```

Visit [http://localhost:8000](http://localhost:8000) and you're ready! 🚀

## 🎯 Why EyoPHP?

**Perfect for learning, teaching, and rapid prototyping**

### ✅ **What you get out of the box:**

-   🏠 **Working homepage** immediately after installation
-   🔐 **Complete authentication** (register/login/logout)
-   🛣️ **Simple routing** with clean URLs
-   🗃️ **Database integration** with PDO
-   📁 **MVC structure** without over-engineering
-   🔒 **User permissions** system
-   ✅ **Input validation** with customizable rules
-   🎨 **Template system** with layouts
-   🧪 **PHPUnit tests** included

### 🎓 **Educational Philosophy:**

-   **Pure PHP** - No magic, you understand every line
-   **Modern standards** - PSR-4 autoloading, Composer, .env
-   **Real-world patterns** - MVC, Router, Middleware
-   **Progressive learning** - Start simple, add complexity when needed

### 🚀 **Developer Experience:**

```php
// Simple routing with permission levels
$router->addPublicRoute('GET', BASE_URL . 'about', 'EyoPHP\\Framework\\Controller\\AppController', 'aboutPage');
$router->addUserRoute('GET', BASE_URL . 'home', 'EyoPHP\\Framework\\Controller\\AppController', 'homePage');

// Easy database access
$user = UserModel::findByEmail($email);

// Clean validation
$validator = new Validator($data);
$validator->required('email')->email();
```

## 📁 Project Structure

```
my-project/
├── public/                # Web root
│   ├── index.php         # Application entry point
│   └── .htaccess         # URL rewriting rules
├── src/                  # Framework core (PSR-4)
│   ├── Controller/       # Application controllers
│   ├── Model/           # Data models
│   ├── Core/            # Framework core classes
│   └── Validation/      # Input validation
├── views/               # HTML templates
│   ├── head.php         # HTML head
│   ├── header.php       # Site header
│   ├── home.php         # Homepage
│   └── footer.php       # Site footer
├── config/              # Configuration files
│   ├── config.php       # Main configuration
│   ├── routes.php       # Route definitions
│   └── middleware.php   # Middleware setup
├── database/            # SQL scripts
│   └── users.sql        # User table schema
├── .env.example         # Environment template
└── composer.json        # Dependencies
```

## 🛠️ Key Features

### **Router with Clean URLs**

```php
// config/routes.php - Real EyoPHP routing system
$router->addPublicRoute('GET', BASE_URL, 'EyoPHP\\Framework\\Controller\\AppController', 'homePage');
$router->addPublicRoute('GET', BASE_URL . 'about', 'EyoPHP\\Framework\\Controller\\AppController', 'aboutPage');
$router->addPublicRoute('POST', BASE_URL . 'login', 'EyoPHP\\Framework\\Controller\\AuthController', 'login');
$router->addUserRoute('GET', BASE_URL . 'home', 'EyoPHP\\Framework\\Controller\\AppController', 'homePage');
```

### **Database with PDO**

```php
// src/Model/UserModel.php - Real EyoPHP method
public function findByEmail(string $email): ?User
{
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $this->db->prepare($query);
    $stmt->execute(['email' => $email]);
    $result = $stmt->fetch();
    return $result ? User::fromArray($result) : null;
}
```

### **Permission-Based Routing**

```php
// EyoPHP's unique 3-level permission system
$router->addPublicRoute('GET', BASE_URL . 'about', 'Controller', 'method');     // Anyone can access
$router->addUserRoute('GET', BASE_URL . 'profile', 'Controller', 'method');    // Logged users only
$router->addAdminRoute('GET', BASE_URL . 'admin', 'Controller', 'method');     // Admins only
```

### **Input Validation**

```php
// Validate user registration
$validator = new Validator($_POST);
$validator->required('email')->email()
          ->required('password')->minLength(8)
          ->required('name')->minLength(2);

if ($validator->isValid()) {
    // Process registration
}
```

### **Template System**

```php
// src/Controller/AppController.php - Real method
public function homePage(): void
{
    $this->renderView('home', [
        'title' => 'Welcome to EyoPHP',
        'message' => 'Your framework is ready!'
    ]);
}
```

## 🚀 Usage Examples

### Creating a New Controller

```php
<?php
namespace EyoPHP\Framework\Controller;

class ProductController
{
    public function listProducts(): void
    {
        // Example: Get products from database
        $products = [
            ['id' => 1, 'name' => 'Product 1', 'price' => 99.99],
            ['id' => 2, 'name' => 'Product 2', 'price' => 149.99]
        ];

        $this->renderView('products/list', [
            'title' => 'Our Products',
            'products' => $products
        ]);
    }

    public function showProduct(int $id): void
    {
        // Example: Get single product
        $product = ['id' => $id, 'name' => 'Product ' . $id, 'price' => 99.99];

        $this->renderView('products/show', [
            'title' => 'Product Details',
            'product' => $product
        ]);
    }
}
```

### Adding Routes

```php
// config/routes.php - Add your new routes
$router->addPublicRoute('GET', BASE_URL . 'products', 'EyoPHP\\Framework\\Controller\\ProductController', 'listProducts');
$router->addPublicRoute('GET', BASE_URL . 'products/{id}', 'EyoPHP\\Framework\\Controller\\ProductController', 'showProduct');

// User-only routes (require login)
$router->addUserRoute('GET', BASE_URL . 'dashboard', 'EyoPHP\\Framework\\Controller\\AppController', 'dashboard');
```

### Creating a Model

```php
<?php
namespace EyoPHP\Framework\Model;

use EyoPHP\Framework\Core\Database;

class ProductModel
{
    public static function getAll(): array
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM products ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $data): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO products (name, price, description) VALUES (:name, :price, :description)");
        return $stmt->execute([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description']
        ]);
    }
}
```

## 🔧 Development Tools

### Testing

```bash
# Run tests
composer test

# With coverage
composer test-coverage
```

### Documentation

```bash
# Generate API docs
composer docs

# Serve documentation
composer docs-serve
```

### Development Server

```bash
# Quick start
php -S localhost:8000 -t public

# With automatic restart (if you have nodemon)
nodemon --exec "php -S localhost:8000 -t public" --ext php
```

## 📚 Learning Path

### Beginner

1. 📖 Follow the Quick Start guide
2. 🔍 Explore the code structure
3. 📝 Modify the homepage template
4. ➕ Add a new route and controller

### Intermediate

1. 🗃️ Create custom models
2. ✅ Add input validation to forms
3. 🔐 Implement user permissions
4. 🧪 Write unit tests

### Advanced

1. 🔧 Create custom middleware
2. 📊 Add logging and monitoring
3. 🚀 Deploy to production
4. 🔄 Migrate to Symfony/Laravel

## 🌟 Perfect For

-   🎓 **Learning PHP** and web development basics
-   🏫 **Teaching MVC** patterns in schools
-   ⚡ **Rapid prototyping** of web applications
-   🔬 **Understanding** how frameworks work internally
-   🚀 **Starting projects** that might grow into larger frameworks

## 🚫 Not For You If

-   You need a battle-tested production framework → Use **Symfony** or **Laravel**
-   You want advanced features out-of-the-box → Use **CodeIgniter** or **CakePHP**
-   You're building complex enterprise applications → Use **Zend/Laminas**

## 🔄 Migration Path

EyoPHP uses standard PHP patterns. When you're ready to scale:

-   **To Symfony**: Controllers and routing concepts are similar
-   **To Laravel**: Model and validation patterns translate well
-   **To any framework**: You'll understand the underlying concepts

## 🤝 Contributing

This framework is designed for educational purposes. Contributions welcome!

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

MIT License - Free for personal and commercial use.

---

> _"The best way to learn how something works is to build it yourself"_

**Ready to start?** Run `composer create-project eyo/fw-php my-app` and begin your journey! 🚀
