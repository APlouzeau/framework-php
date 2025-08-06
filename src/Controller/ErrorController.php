<?php

namespace EyoPHP\Framework\Controller;

/**
 * ErrorController - Gestion des erreurs 404 et autres erreurs
 *
 * @package EyoPHP\Framework\Controller
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */
class ErrorController
{
    /**
     * Page d'accueil temporaire pour tester le framework
     */
    public function home(): void
    {
        echo "<!DOCTYPE html>";
        echo "<html><head><title>🚀 EyoPHP Framework</title></head>";
        echo "<body>";
        echo "<h1>🚀 Bienvenue sur EyoPHP Framework !</h1>";
        echo "<p>✅ Le framework fonctionne correctement.</p>";
        echo "<p>📖 Version: " . \EyoPHP\Framework\Framework::version() . "</p>";
        echo "<p>🎯 Cette page est générée par ErrorController::home()</p>";
        echo "<ul>";
        echo "<li><a href='/login'>Page de connexion</a></li>";
        echo "<li><a href='/register'>Page d'inscription</a></li>";
        echo "<li><a href='/about'>À propos</a></li>";
        echo "</ul>";
        echo "</body></html>";
    }

    /**
     * Affiche une page d'erreur
     */
    public function index($handler, $method, $uri): void
    {
        http_response_code(404);

        echo "<!DOCTYPE html>";
        echo "<html><head><title>Erreur 404 - Page non trouvée</title></head>";
        echo "<body>";
        echo "<h1>Erreur 404 - Page non trouvée</h1>";
        echo "<p>La page demandée n'existe pas.</p>";
        echo "<p><strong>Méthode:</strong> " . htmlspecialchars($method) . "</p>";
        echo "<p><strong>URI:</strong> " . htmlspecialchars($uri) . "</p>";

        $isDebugMode = defined('APP_DEBUG') && constant('APP_DEBUG');
        if ($isDebugMode) {
            echo "<hr>";
            echo "<h2>Informations de débogage</h2>";
            echo "<pre>";
            var_dump($handler);
            echo "</pre>";
        }

        echo "</body></html>";
    }

    /**
     * Affiche une erreur 500
     */
    public function serverError(\Throwable $exception = null): void
    {
        http_response_code(500);

        echo "<!DOCTYPE html>";
        echo "<html><head><title>Erreur 500 - Erreur serveur</title></head>";
        echo "<body>";
        echo "<h1>Erreur 500 - Erreur serveur</h1>";
        echo "<p>Une erreur interne s'est produite.</p>";

        $isDebugMode = defined('APP_DEBUG') && constant('APP_DEBUG');
        if ($isDebugMode && $exception) {
            echo "<hr>";
            echo "<h2>Informations de débogage</h2>";
            echo "<pre>";
            echo htmlspecialchars($exception->getMessage());
            echo "\n\n" . htmlspecialchars($exception->getTraceAsString());
            echo "</pre>";
        }

        echo "</body></html>";
    }
}
