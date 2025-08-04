<?php

class ControllerUserLogin
{

    private $router = new ControllerAppPages();
    public function login()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pseudo = $_POST['pseudo'];
            $password = $_POST['password'];

            $userModel = new ModelUser();
            $user = new EntitieUser([
                'pseudo' => $pseudo,
                'password' => $password
            ]);
            $userVerify = $userModel->login($user);
            if ($userVerify) {

                $_SESSION = [
                    'id_user' => $userVerify->getid_user(),
                    'pseudo' => $userVerify->getPseudo(),
                    'firstname' => $userVerify->getPseudo(),
                    'email' => $userVerify->getMail(),
                ];

                $this->router->homePage();
            } else {
                $error = "Nom ou mot de passe incorrect.";
                require_once APP_PATH . "/views/login.php";
            }
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: index.php");
        exit();
    }

    public function register()
    {
        if (isset($_POST['pseudo']) and !empty($_POST['password'])) {
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $mdp = sha1($_POST['password']);
            $user = new EntitieUser([
                "pseudo" => $pseudo,
                "password" => $mdp
            ]);
            var_dump($user);
            $userModel = new ModelUser();
            $userModel->register($user);
            header("Location: " . BASE_URL . "login");
        }
    }




    public function deleteUser()
    {
        $response = [
            'errno' => 1,
            'errmsg' => 'Erreur inconnue',
            'data' => []
        ];
        if (!$_SESSION) {
            $response['errmsg'] = 'Utilisateur non connecté';
        } else if (!$_POST['id_user']) {
            $response['errmsg'] = 'Paramêtre manquant';
        } else if ($_SESSION['role'] != 'admin') {
            $response['errmsg'] = 'Utilisateur non autorisé';
        } else {
            $id_user = $_POST['id_user'];
            $modelUser = new ModelUser();
            $user = new EntitieUser([
                'id_user' => $id_user
            ]);
            $modelUser->deleteUser($user);
            $response = [
                'errno' => 0,
                'errmsg' => 'Utilisateur supprimé',
                'data' => [
                    'id_user' => $id_user
                ]
            ];
        }
        echo json_encode($response);
        exit();
    }
}
