# EyoPHP Framework Makefile
# Commandes pour les tâches courantes du développement

.PHONY: help install test test-coverage serve clean setup setup-db docs docs-generate code-style

# Afficher l'aide (target par défaut)
help: ## Afficher toutes les commandes disponibles
	@echo EyoPHP Framework - Commandes disponibles:
	@echo.
	@echo   install          Installer les dependances Composer
	@echo   test             Lancer les tests PHPUnit  
	@echo   test-coverage    Tests avec rapport de couverture
	@echo   serve            Demarrer le serveur de developpement
	@echo   clean            Nettoyer les fichiers temporaires
	@echo   setup            Configuration complete du projet
	@echo   setup-db         Initialiser la base de donnees
	@echo   docs             Afficher les options de documentation
	@echo   docs-generate    Instructions pour generer la doc HTML
	@echo   code-style       Nettoyer le style de code (SonarQube)
	@echo.
	@echo Demarrage rapide:
	@echo   1. make setup      (installation + configuration)
	@echo   2. make setup-db   (base de donnees)
	@echo   3. make serve      (serveur de developpement)
	@echo.

install: ## Installer les dépendances Composer
	@echo "📦 Installation des dépendances..."
	composer install
	@echo "✅ Dépendances installées!"

test: ## Lancer les tests PHPUnit
	@echo "🧪 Exécution des tests..."
	vendor/bin/phpunit
	@echo "✅ Tests terminés!"

test-coverage: ## Lancer les tests avec rapport de couverture
	@echo "🧪 Tests avec couverture de code..."
	@if not exist tests/results mkdir tests\results
	vendor/bin/phpunit --coverage-html tests/results/coverage --coverage-text
	@echo "📊 Rapport généré: tests/results/coverage/index.html"

serve: ## Démarrer le serveur de développement
	@echo "🚀 Démarrage du serveur..."
	@echo "🌐 Accès: http://localhost:8000"
	@echo "⏹️  Arrêt: Ctrl+C"
	php -S localhost:8000 -t public/

clean: ## Nettoyer les fichiers temporaires
	@echo "🧹 Nettoyage des fichiers temporaires..."
	@if exist cache rmdir /s /q cache
	@if exist logs rmdir /s /q logs
	@if exist tmp rmdir /s /q tmp
	@if exist tests\results rmdir /s /q tests\results
	@echo "✅ Nettoyage terminé!"

setup: install ## Configuration complète du projet
	@echo "⚙️  Configuration de l'environnement..."
	@if not exist .env copy .env.example .env
	@echo "✅ Configuration terminée!"
	@echo ""
	@echo "📝 Prochaines étapes:"
	@echo "  1. Éditez .env avec vos paramètres DB"
	@echo "  2. Lancez: make setup-db"
	@echo "  3. Lancez: make serve"

setup-db: ## Initialiser la base de données
	@echo "🗄️  Configuration de la base de données..."
	@echo "⚠️  Assurez-vous d'avoir configuré .env d'abord!"
	@echo ""
	@echo "🔧 Commandes à exécuter manuellement:"
	@echo "  mysql -u root -p < database/users.sql"
	@echo "  # ou"
	@echo "  mysql -u root -p -D votre_base < database/users.sql"
	@echo ""
	@echo "📋 Le script créera:"
	@echo "  • Tables: roles, users"
	@echo "  • Utilisateurs test: admin, moderator, testuser, alice"
	@echo "  • Mot de passe par défaut: password123"

docs: ## Afficher les options de documentation
	@echo "📚 Documentation EyoPHP Framework"
	@echo "================================="
	@echo ""
	@echo "� Documentation intégrée VS Code (RECOMMANDÉ):"
	@echo "  • Survol des méthodes = documentation PHPDoc"
	@echo "  • Auto-complétion avec aide contextuelle"
	@echo "  • Ctrl+Click = aller à la définition"
	@echo ""
	@echo "� Documentation Markdown:"
	@echo "  • README.md (général)"
	@echo "  • PERMISSIONS_GUIDE.md (système de permissions)"
	@echo "  • docs/API.md (référence API)"
	@echo ""
	@echo "🌐 Génération HTML:"
	@echo "  • make docs-generate (instructions Docker)"

docs-generate: ## Instructions pour générer la doc HTML
	@echo "📦 Génération documentation HTML"
	@echo "==============================="
	@echo ""
	@echo "🐳 Avec Docker (RECOMMANDÉ):"
	@echo "  docker run --rm -v \"%cd%:/data\" phpdoc/phpdoc:3 \\"
	@echo "    run -d class,controller,model,traits \\"
	@echo "    -t docs/html \\"
	@echo "    --title=\"EyoPHP Framework Documentation\""
	@echo ""
	@echo "📂 Résultat: docs/html/index.html"
	@echo "⚠️  Note: Problèmes possibles avec espaces dans chemins Windows"

code-style: ## Nettoyer le style de code selon SonarQube
	@echo "🧹 Nettoyage du style de code..."
	@echo "Suppression des trailing whitespaces..."
	@powershell -Command "Get-ChildItem -Path 'class', 'controller', 'model', 'config', 'views', 'traits' -Filter '*.php' -Recurse | ForEach-Object { $$content = Get-Content $$_.FullName -Raw; $$cleaned = $$content -replace ' +\r?\n', \"`n\"; $$cleaned = $$cleaned -replace ' +$$', ''; Set-Content $$_.FullName $$cleaned -NoNewline }"
	@echo "Ajout des nouvelles lignes finales..."
	@powershell -Command "Get-ChildItem -Path 'class', 'controller', 'model', 'config', 'views', 'traits', 'public' -Filter '*.php' -Recurse | ForEach-Object { $$content = Get-Content $$_.FullName -Raw; if (-not $$content.EndsWith(\"`n\")) { $$content += \"`n\" }; Set-Content $$_.FullName $$content -NoNewline }"
	@echo "✅ Nettoyage terminé!"
