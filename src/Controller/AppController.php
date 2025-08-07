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
            'description' => 'Connectez-vous à votre compte EyoPHP Framework pour accéder à votre espace personnel'
        ]);
    }

    /**
     * Page d'inscription
     */
    public function registerPage()
    {
        $this->renderView('register', [
            'title' => 'Inscription',
            'description' => 'Créez votre compte gratuit sur EyoPHP Framework et commencez à développer vos projets web'
        ]);
    }

    /**
     * Page d'accueil pour les utilisateurs connectés
     */
    public function homePage()
    {
        $this->renderView('home', [
            'title' => 'Accueil',
            'description' => 'Tableau de bord EyoPHP Framework - Gérez vos projets et accédez à toutes les fonctionnalités',
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
            'description' => 'Découvrez EyoPHP Framework v0.1.0 - Un framework PHP éducatif, minimaliste et moderne pour apprendre le développement web',
            'framework' => 'EyoPHP Framework v0.1.0'
        ]);
    }

    /**
     * Page Contact
     */
    public function contactPage()
    {
        $this->renderView('contact', [
            'title' => 'Contact',
            'description' => 'Contactez l\'équipe EyoPHP Framework pour vos questions, suggestions ou support technique'
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
