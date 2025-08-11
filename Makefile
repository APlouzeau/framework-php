# EyoPHP Framework - Development Makefile
# Useful commands for framework development and testing

.PHONY: help install test test-coverage serve clean setup setup-db docs docs-generate docs-serve example code-style

# Default target
help: ## Show all available commands
	@echo "🚀 EyoPHP Framework - Available Commands"
	@echo "========================================"
	@echo ""
	@echo "📦 Installation & Setup:"
	@echo "  make install       - Install dependencies via Composer"
	@echo "  make setup         - Complete project setup"
	@echo "  make setup-db      - Initialize database"
	@echo ""
	@echo "🧪 Testing:"
	@echo "  make test          - Run all PHPUnit tests"
	@echo "  make test-unit     - Run only unit tests"
	@echo "  make test-integration - Run only integration tests"
	@echo "  make test-coverage - Run tests with coverage report"
	@echo ""
	@echo "📚 Documentation:"
	@echo "  make docs          - Show documentation options"
	@echo "  make docs-generate - Generate API documentation with Docker"
	@echo "  make docs-serve    - Serve documentation on localhost:8080"
	@echo ""
	@echo "🚀 Development:"
	@echo "  make serve         - Start development server on localhost:8000"
	@echo "  make pma           - Start phpMyAdmin on localhost:8081"
	@echo "  make dev-full      - Instructions for both servers"
	@echo "  make example       - Run example.php"
	@echo ""
	@echo "🧹 Maintenance:"
	@echo "  make clean         - Clean generated files"
	@echo "  make code-style    - Clean code style (remove trailing spaces)"
	@echo ""
	@echo "Quick start workflow:"
	@echo "  1. make setup      (installation + configuration)"
	@echo "  2. make setup-db   (database setup)"
	@echo "  3. make serve      (development server)"

# Installation
install: ## Install dependencies via Composer
	@echo "📦 Installing dependencies..."
	composer install
	@echo "✅ Dependencies installed!"

# Setup
setup: install ## Complete project setup
	@echo "⚙️ Setting up environment..."
	@if not exist .env copy .env.example .env
	@echo "✅ Setup complete!"
	@echo ""
	@echo "📝 Next steps:"
	@echo "  1. Edit .env with your database settings"
	@echo "  2. Run: make setup-db"
	@echo "  3. Run: make serve"

setup-db: ## Initialize database
	@echo "🗄️ Database setup..."
	@echo "⚠️  Make sure to configure .env first!"
	@echo ""
	@echo "🔧 Commands to run manually:"
	@echo "  mysql -u root -p < database/users.sql"
	@echo "  # or"
	@echo "  mysql -u root -p -D your_database < database/users.sql"
	@echo ""
	@echo "📋 The script will create:"
	@echo "  • Tables: roles, users"
	@echo "  • Test users: admin, moderator, testuser, alice"
	@echo "  • Default password: password123"

# Testing
test: ## Run PHPUnit tests
	@echo "🧪 Running tests..."
	./vendor/bin/phpunit tests --bootstrap tests/bootstrap.php --no-configuration --testdox
	@echo "✅ Tests completed!"

test-unit: ## Run only unit tests
	@echo "🧪 Running unit tests..."
	./vendor/bin/phpunit tests/Unit --bootstrap tests/bootstrap.php --no-configuration --testdox
	@echo "✅ Unit tests completed!"

test-integration: ## Run only integration tests
	@echo "🧪 Running integration tests..."
	./vendor/bin/phpunit tests/Integration --bootstrap tests/bootstrap.php --no-configuration --testdox
	@echo "✅ Integration tests completed!"

test-coverage: ## Run tests with coverage report
	@echo "🧪 Running tests with coverage..."
	@if not exist tests\results mkdir tests\results
	./vendor/bin/phpunit tests --bootstrap tests/bootstrap.php --no-configuration --coverage-html tests/results/coverage --coverage-text
	@echo "📊 Coverage report: tests/results/coverage/index.html"

# Development
serve: ## Start development server on localhost:8000
	@echo "🚀 Starting development server..."
	@echo "🌐 Access: http://localhost:8000"
	@echo "⏹️  Stop: Ctrl+C"
	php -S localhost:8000 -t public/

example: ## Run example.php
	@echo "💡 Running example.php..."
	php example.php

# Maintenance
clean: ## Clean generated files
	@echo "🧹 Cleaning temporary files..."
	@if exist cache rmdir /s /q cache
	@if exist logs rmdir /s /q logs
	@if exist tmp rmdir /s /q tmp
	@if exist tests\results rmdir /s /q tests\results
	@if exist .phpunit.result.cache del .phpunit.result.cache
	@echo "✅ Cleanup completed!"

code-style: ## Clean code style (remove trailing spaces)
	@echo "🧹 Cleaning code style..."
	@echo "Removing trailing whitespaces..."
	@powershell -Command "Get-ChildItem -Path 'src', 'class', 'controller', 'config', 'views', 'traits' -Filter '*.php' -Recurse | ForEach-Object { $$content = Get-Content $$_.FullName -Raw; $$cleaned = $$content -replace ' +\r?\n', \"`n\"; $$cleaned = $$cleaned -replace ' +$$', ''; Set-Content $$_.FullName $$cleaned -NoNewline }"
	@echo "Adding final newlines..."
	@powershell -Command "Get-ChildItem -Path 'src', 'class', 'controller', 'config', 'views', 'traits', 'public' -Filter '*.php' -Recurse | ForEach-Object { $$content = Get-Content $$_.FullName -Raw; if (-not $$content.EndsWith(\"`n\")) { $$content += \"`n\" }; Set-Content $$_.FullName $$content -NoNewline }"
	@echo "✅ Code style cleanup completed!"

# Quick development workflow
dev: install test serve

# Release preparation
release: clean install test docs-generate
	@echo "✅ Framework ready for release!"

# phpMyAdmin
pma: ## Start phpMyAdmin on localhost:8081
	@echo "🚀 Starting phpMyAdmin..."
	@echo "🌐 Access: http://localhost:8081"
	@echo "⏹️  Stop: Ctrl+C"
	@cd phpmyadmin && php -S localhost:8081

# Combined development servers
dev-full: ## Start both framework and phpMyAdmin
	@echo "🚀 Starting development environment..."
	@echo "📱 Framework: http://localhost:8000"
	@echo "🗄️  phpMyAdmin: http://localhost:8081"
	@echo ""
	@echo "⚠️  You need to run these in separate terminals:"
	@echo "  Terminal 1: make serve"
	@echo "  Terminal 2: make pma"

