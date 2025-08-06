<?php

namespace EyoPHP\Framework\Controller;

/**
 * Contrôleur pour les pages de l'application
 */
class AppController
{
    /**
     * Page d'accueil/login
     */
    public function loginPage()
    {
        $this->renderView('login', [
            'title' => 'Connexion',
            'message' => 'Bienvenue sur EyoPHP Framework'
        ]);
    }

    /**
     * Page d'inscription
     */
    public function registerPage()
    {
        $this->renderView('register', [
            'title' => 'Inscription',
            'message' => 'Créer votre compte'
        ]);
    }

    /**
     * Page d'accueil pour les utilisateurs connectés
     */
    public function homePage()
    {
        $this->renderView('home', [
            'title' => 'Accueil',
            'user' => $_SESSION['user'] ?? null
        ]);
    }

    /**
     * Page À propos
     */
    public function aboutPage()
    {
        $this->renderView('about', [
            'title' => 'À propos',
            'framework' => 'EyoPHP Framework v0.1.0'
        ]);
    }

    /**
     * Page Contact
     */
    public function contactPage()
    {
        $this->renderView('contact', [
            'title' => 'Contact'
        ]);
    }

    /**
     * Page Tarifs
     */
    public function pricingPage()
    {
        $this->renderView('pricing', [
            'title' => 'Nos tarifs'
        ]);
    }

    /**
     * Rendu d'une vue
     */
    private function renderView(string $view, array $data = [])
    {
        // Extraire les données pour les rendre disponibles dans la vue
        extract($data);

        // Définir le chemin vers les vues
        $viewPath = APP_PATH . "views/" . $view . ".php";

        // Vérifier si la vue existe
        if (!file_exists($viewPath)) {
            echo "<h1>Erreur 404</h1>";
            echo "<p>La vue '$view' est introuvable.</p>";
            echo "<p>Chemin recherché : $viewPath</p>";
            return;
        }

        // Inclure les éléments communs
        include_once APP_PATH . "views/head.php";
        include_once APP_PATH . "views/header.php";

        // Inclure la vue demandée
        include_once $viewPath;

        // Inclure le pied de page
        include_once APP_PATH . "views/footer.php";
    }
}
