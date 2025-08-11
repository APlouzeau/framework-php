<?php

namespace EyoPHP\Framework\Controller;

use EyoPHP\Framework\Validation\Validator;
use EyoPHP\Framework\Controller\AppController;
use EyoPHP\Framework\Model\UserModel;
use EyoPHP\Framework\Entity\User;

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

        $nickName = $_POST['nickName'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';

        $rules = [
            'nickName' => [
                ['required'],           // Champ obligatoire
            ],
            'email' => [
                ['required'],           // Champ obligatoire
                ['email'],              // Doit être un email valide
            ],
            'password' => [
                ['required'],           // Champ obligatoire
                ['password'],           // Format de mot de passe
                ['length', 8, 20]       // Entre 8 et 20 caractères
            ],
            'confirmPassword' => [
                ['required'],           // Champ obligatoire
                ['match', 'password'],  // Doit correspondre au mot de passe
            ],
        ];

        $formData = [
            'nickName' => $nickName,
            'email' => $email,
            'password' => $password,
            'confirmPassword' => $confirmPassword  // ✅ Ajouté: confirmPassword manquait
        ];

        $validation = Validator::validateForm($formData, $rules);

        if (!$validation['valid']) {
            // ✅ Correct: Utilise AppController::renderView (méthode statique)
            AppController::renderView('register', [
                'title' => 'Register',
                'description' => 'Create your free account on EyoPHP Framework and start developing your web projects',
                'errors' => $validation['errors'],
                'data' => $formData
            ]);
            return;
        }

        // Création de l'utilisateur avec les bons noms de propriétés
        $user = new User([
            'nickName' => $nickName,  // ✅ nickName (comme dans l'Entity)
            'email' => $email,        // ✅ email (comme dans l'Entity)
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'id_role' => 1           // Rôle utilisateur par défaut
        ]);

        // ✅ Correct: UserModel est une instance (pas statique)
        $userModel = new UserModel();
        $result = $userModel->register($user);

        if ($result) {
            // Inscription réussie - redirection vers login
            header('Location: ' . BASE_URL . 'connexion');
            exit;
        } else {
            // Erreur lors de l'inscription
            AppController::renderView('register', [
                'title' => 'Register',
                'description' => 'Create your free account on EyoPHP Framework and start developing your web projects',
                'errors' => ['general' => ['Une erreur est survenue lors de l\'inscription']],
                'data' => $formData
            ]);
            return;
        }
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
