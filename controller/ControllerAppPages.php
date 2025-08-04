<?php

class ControllerAppPages
{
    private $siteName = "My site";
    public function homePage()
    {
        $titlePage = "{$this->siteName} : Accueil";
        require_once APP_PATH . "/views/head.php";
        require_once APP_PATH . "/views/header.php";
        require_once APP_PATH . "/views/home.php";
        require_once APP_PATH . "/views/footer.php";
    }

    public function loginPage()
    {
        $titlePage = "{$this->siteName} : Connexion";
        require_once APP_PATH . "/views/head.php";
        require_once APP_PATH . "/views/header.php";
        require_once APP_PATH . "/views/login.php";
        require_once APP_PATH . "/views/footer.php";
    }

    public function profilPage()
    {
        $titlePage = "{$this->siteName} : Profil";
        $modelUser = new ModelUser();
        $user = new EntitieUser([
            'id_user' => $_SESSION['id_user']
        ]);
        require_once APP_PATH . "/views/head.php";
        require_once APP_PATH . "/views/header.php";
        $userChecked = $modelUser->getUser($user);
        require_once APP_PATH . "/views/profile.php";
        require_once APP_PATH . "/views/footer.php";
    }
    public function registerPage()
    {
        $titlePage = "{$this->siteName} : Inscription";
        require_once APP_PATH . "/views/head.php";
        require_once APP_PATH . "/views/header.php";
        require_once APP_PATH . "/views/register.php";
        require_once APP_PATH . "/views/footer.php";
    }

    public function listUsersPage()
    {
        $modelUser = new ModelUser();
        $users = $modelUser->getAllUsers();

        require_once APP_PATH . "/views/head.php";
        require_once APP_PATH . "/views/header.php";
        require_once APP_PATH . "/views/listUsers.php";
        require_once APP_PATH . "/views/footer.php";
    }
}
