<?php

namespace EyoPHP\Framework\Controller;

/**
 * Contrôleur pour l'authentification des utilisateurs
 */
class AuthController
{
    /**
     * Traiter la connexion
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validation basique
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Email et mot de passe requis.';
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        // TODO: Authentification réelle avec base de données
        // Pour le moment, on simule un utilisateur
        if ($email === 'admin@example.com' && $password === 'admin') {
            $_SESSION['user'] = [
                'id' => 1,
                'email' => $email,
                'name' => 'Administrateur',
                'role' => 'admin'
            ];
            $_SESSION['success'] = 'Connexion réussie !';
            header('Location: ' . BASE_URL . 'home');
        } else {
            $_SESSION['error'] = 'Email ou mot de passe incorrect.';
            header('Location: ' . BASE_URL . 'login');
        }
        exit;
    }

    /**
     * Traiter l'inscription
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'register');
            exit;
        }

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validation basique
        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['error'] = 'Tous les champs sont requis.';
            header('Location: ' . BASE_URL . 'register');
            exit;
        }

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Les mots de passe ne correspondent pas.';
            header('Location: ' . BASE_URL . 'register');
            exit;
        }

        // TODO: Enregistrement en base de données
        // Pour le moment, on simule un enregistrement réussi
        $_SESSION['success'] = 'Inscription réussie ! Vous pouvez maintenant vous connecter.';
        header('Location: ' . BASE_URL . 'login');
        exit;
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        session_destroy();
        header('Location: ' . BASE_URL);
        exit;
    }
}
