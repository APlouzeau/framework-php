# 🚀 EyoPHP Framework - Installation Guide

## Two Installation Modes

EyoPHP Framework provides two installation modes to match your specific needs:

### 🚀 Complete Mode (Recommended)

**Perfect for:**
- Professional development projects
- Learning best practices through examples
- Teams wanting tested, reliable code
- Comprehensive development environment

**What's included:**
- ✅ Complete test suite with PHPUnit
- ✅ Example tests showing professional patterns
- ✅ Documentation generation tools (phpDocumentor)
- ✅ Example usage file (`example.php`)
- ✅ Development tools and utilities

**Installation:**
```bash
composer create-project eyo/fw-php my-project
# Choose option [1] when prompted
```

**Available commands:**
```bash
composer test                # Run all tests
composer test-coverage      # Generate coverage report
composer docs               # Generate API documentation
php example.php             # See framework examples
```

### ⚡ Minimal Mode

**Perfect for:**
- Experienced developers with existing testing workflows
- Quick prototyping and experimentation
- Custom setups where you'll add your own tools
- Minimal footprint installations

**What's included:**
- ✅ Core framework files only
- ✅ Optimized for custom development
- ✅ Smaller footprint
- ⚠️ You'll need to add your own test suite

**Installation:**
```bash
composer create-project eyo/fw-php my-project
# Choose option [2] when prompted
```

## Manual Cleanup (Alternative)

If you want to switch from Complete to Minimal mode later:

```bash
# Remove test files
rm -rf tests/ phpunit.xml .phpunit.result.cache

# Remove documentation tools
rm -rf docs-template/ phpdoc.xml*

# Remove examples
rm example.php
```

## Getting Started

After installation, regardless of the mode chosen:

1. **Configure your database** in `config/config.php`
2. **Start the development server:**
   ```bash
   php -S localhost:8000 -t public/
   ```
3. **Visit** http://localhost:8000

## What's Next?

- Read the [README.md](README.md) for detailed documentation
- Check out the [API documentation](docs/API.md)
- Explore the example controllers in `src/Controller/`
- Start building your application!

---

**Happy coding with EyoPHP Framework! 🎉**
