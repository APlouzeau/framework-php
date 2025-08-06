<?php

use EyoPHP\Framework\Entity\User;
use EyoPHP\Framework\Model\UserModel;

class ControllerAppPages
{
    use TraitsPageRenderer;

    private $siteName = "My site";

    // Legacy view constants kept for backward compatibility
    private const VIEW_HOME = "/views/home.php";
    private const VIEW_LOGIN = "/views/login.php";
    private const VIEW_REGISTER = "/views/register.php";
    private const VIEW_PROFILE = "/views/profile.php";
    private const VIEW_LIST_USERS = "/views/listUsers.php";

    public function homePage()
    {
        $this->generatePage(self::VIEW_HOME, "Accueil", [], $this->siteName);
    }

    public function loginPage()
    {
        $this->generatePage(self::VIEW_LOGIN, "Connexion", [], $this->siteName);
    }

    public function profilPage()
    {
        // Prepare data for profile page
        $modelUser = new UserModel();
        $user = new User([
            'id_user' => $_SESSION['id_user']
        ]);
        $userChecked = $modelUser->getUser($user);

        $this->generatePage(self::VIEW_PROFILE, "Profil", [
            'userChecked' => $userChecked
        ], $this->siteName);
    }

    public function registerPage()
    {
        $this->generatePage(self::VIEW_REGISTER, "Inscription", [], $this->siteName);
    }

    public function listUsersPage()
    {
        // Prepare data for users list page
        $modelUser = new UserModel();
        $users = $modelUser->getAllUsers();

        $this->generatePage(self::VIEW_LIST_USERS, "Liste des utilisateurs", [
            'users' => $users
        ], $this->siteName);
    }

    public function doc()
    {
        $this->generatePage("/views/doc.php", "Documentation", [], $this->siteName);
    }
}
