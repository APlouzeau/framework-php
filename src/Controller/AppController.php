<?php

namespace EyoPHP\Framework\Controller;

/**
 * Controller for application pages
 */
class AppController
{
    /**
     * Home/login page
     */
    public function loginPage()
    {
        self::renderView('login', [
            'title' => 'Connexion',
            'description' => 'Connectez-vous à votre compte EyoPHP Framework pour accéder à votre espace personnel'
        ]);
    }

    /**
     * Registration page
     */
    public function registerPage()
    {
        self::renderView('register', [
            'title' => 'Register',
            'description' => 'Create your free account on EyoPHP Framework and start developing your web projects'
        ]);
    }

    /**
     * Home page for logged in users
     */
    public function homePage()
    {
        self::renderView('home', [
            'title' => 'Home',
            'description' => 'EyoPHP Framework Dashboard - Manage your projects and access all features',
            'user' => $_SESSION['user'] ?? null
        ]);
    }

    /**
     * About page
     */
    public function aboutPage()
    {
        self::renderView('about', [
            'title' => 'About',
            'description' => 'Discover EyoPHP Framework v0.1.0 - An educational, minimalist and modern PHP framework for learning web development',
            'framework' => 'EyoPHP Framework v0.1.0'
        ]);
    }

    /**
     * Contact page
     */
    public function contactPage()
    {
        self::renderView('contact', [
            'title' => 'Contact',
            'description' => 'Contact the EyoPHP Framework team for your questions, suggestions or technical support'
        ]);
    }

    /**
     * Render a view - Now public and static for use anywhere
     */
    public static function renderView(string $view, array $data = [])
    {
        // Extract data to make it available in the view
        extract($data);

        // Define path to views
        $viewPath = APP_PATH . "views/" . $view . ".php";

        // Check if view exists
        if (!file_exists($viewPath)) {
            echo "<h1>Error 404</h1>";
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
