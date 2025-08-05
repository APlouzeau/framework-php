# EyoPHP Makefile
# Simple commands for common tasks

.PHONY: help install test test-coverage serve clean setup setup-db docs

# Default target
help:
	@echo "EyoPHP Framework - Available Commands:"
	@echo ""
	@echo "  make install        Install dependencies (Composer)"
	@echo "  make test           Run PHPUnit tests"
	@echo "  make test-coverage  Run tests with coverage report"
	@echo "  make serve          Start development server"
	@echo "  make clean          Clean cache and logs"
	@echo "  make setup          Complete setup (install + database)"
	@echo "  make setup-db       Initialize database with schema and test data"
	@echo "  make docs           Generate documentation from PHPDoc comments"
	@echo ""

# Install Composer dependencies
install:
	@echo "📦 Installing dependencies..."
	composer install

# Run tests
test:
	@echo "🧪 Running tests..."
	vendor/bin/phpunit

# Run tests with coverage
test-coverage:
	@echo "🧪 Running tests with coverage..."
	@if not exist tests/results mkdir tests\results
	vendor/bin/phpunit --coverage-html tests/results/coverage --coverage-text
	@echo "📊 Coverage report generated in tests/results/coverage/index.html"

# Start development server
serve:
	@echo "🚀 Starting development server..."
	@echo "Access: http://localhost:8000"
	php -S localhost:8000 -t public/

# Clean temporary files
clean:
	@echo "🧹 Cleaning temporary files..."
	@if exist cache rmdir /s /q cache
	@if exist logs rmdir /s /q logs
	@if exist tmp rmdir /s /q tmp

# Complete setup
setup: install
	@echo "⚙️  Setting up environment..."
	@if not exist .env copy .env.example .env
	@echo "✅ Setup complete!"
	@echo ""
	@echo "Don't forget to:"
	@echo "1. Edit .env with your database credentials"
	@echo "2. Run: make setup-db"
	@echo "3. Run: make serve"

# Initialize database
setup-db:
	@echo "🗄️  Setting up database..."
	@echo "Make sure to edit .env with your database credentials first!"
	@echo ""
	@echo "To create the database, run one of these commands:"
	@echo "  mysql -u root -p < database/users.sql"
	@echo "  mysql -u root -p -D your_database < database/users.sql"
	@echo ""
	@echo "The script will create:"
	@echo "  - Tables: roles, users"
	@echo "  - Test users: admin, moderator, testuser, alice"
	@echo "  - Default password for all test users: password123"

# Generate documentation
docs:
	@echo "📚 Generating documentation..."
	@if not exist docs mkdir docs
	@echo "Generating simple documentation from PHPDoc comments..."
	@echo "Documentation will be in docs/ folder"
	@echo ""
	@echo "For full documentation generation, install phpDocumentor:"
	@echo "  wget https://phpdoc.org/phpDocumentor.phar"
	@echo "  php phpDocumentor.phar -d . -t docs/"
	@echo ""
	@echo "Or use online tools like ApiGen or Sami"
