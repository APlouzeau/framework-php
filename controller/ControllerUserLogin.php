<?php

class ControllerUserLogin
{
    use TraitsPageRenderer;

    private $router;

    // View constants to avoid duplication
    private const VIEW_LOGIN = "/views/login.php";
    private const VIEW_REGISTER = "/views/register.php";

    public function __construct()
    {
        $this->router = new ControllerAppPages();
    }
    public function login()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nickname = $_POST['nickname'] ?? $_POST['pseudo'] ?? ''; // Support both new and old field names
            $password = $_POST['password'] ?? '';

            if (empty($nickname) || empty($password)) {
                $error = "Nickname and password are required.";
                // Using the trait method instead of manual require_once
                $this->generatePage(self::VIEW_LOGIN, "Connexion", ['error' => $error]);
                return;
            }

            $userModel = new ModelUser();
            $user = new EntitieUser([
                'nickname' => $nickname,
                'password' => $password
            ]);

            $userVerify = $userModel->login($user);

            if ($userVerify) {
                $_SESSION = [
                    'id_user' => $userVerify->getId_user(),
                    'nickname' => $userVerify->getNickname(),
                    'pseudo' => $userVerify->getNickname(), // Legacy compatibility
                    'email' => $userVerify->getMail(),
                    'role' => $userVerify->getId_role(),
                    'id_role' => $userVerify->getId_role()
                ];

                $this->router->homePage();
            } else {
                $error = "Invalid nickname or password.";
                // Using trait method instead of manual require_once
                $this->generatePage(self::VIEW_LOGIN, "Connexion", ['error' => $error]);
            }
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: " . BASE_URL);
        exit();
    }

    public function register()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nickname = htmlspecialchars($_POST['nickname'] ?? $_POST['pseudo'] ?? '');
            $email = htmlspecialchars($_POST['email'] ?? $_POST['mail'] ?? '');
            $password = $_POST['password'] ?? '';
            $id_role = (int) ($_POST['id_role'] ?? 1); // Default to user role

            // Basic validation
            if (empty($nickname) || empty($password)) {
                $error = "Nickname and password are required.";
                $this->generatePage(self::VIEW_REGISTER, "Inscription", ['error' => $error]);
                return;
            }

            if (strlen($password) < 6) {
                $error = "Password must be at least 6 characters long.";
                $this->generatePage(self::VIEW_REGISTER, "Inscription", ['error' => $error]);
                return;
            }

            $userModel = new ModelUser();

            // Check if nickname is available
            if (!$userModel->isNicknameAvailable($nickname)) {
                $error = "This nickname is already taken.";
                $this->generatePage(self::VIEW_REGISTER, "Inscription", ['error' => $error]);
                return;
            }

            // Check if email is available (if provided)
            if (!empty($email) && !$userModel->isEmailAvailable($email)) {
                $error = "This email is already registered.";
                $this->generatePage(self::VIEW_REGISTER, "Inscription", ['error' => $error]);
                return;
            }

            $user = new EntitieUser([
                "nickname" => $nickname,
                "mail" => $email,
                "password" => $password, // Will be hashed in ModelUser
                "id_role" => $id_role
            ]);

            if ($userModel->register($user)) {
                // Registration successful, redirect to login
                header("Location: " . BASE_URL . "loginPage?registered=1");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
                $this->generatePage(self::VIEW_REGISTER, "Inscription", ['error' => $error]);
            }
        } else {
            // Display registration form
            $this->generatePage(self::VIEW_REGISTER, "Inscription");
        }
    }

    public function deleteUser()
    {
        $response = [
            'errno' => 1,
            'errmsg' => 'Unknown error',
            'data' => []
        ];

        if (!isset($_SESSION['id_user'])) {
            $response['errmsg'] = 'User not connected';
        } else if (!isset($_POST['id_user'])) {
            $response['errmsg'] = 'Missing parameter';
        } else if (($_SESSION['role'] ?? '') != 'admin') {
            $response['errmsg'] = 'User not authorized';
        } else {
            $id_user = (int) $_POST['id_user'];
            $modelUser = new ModelUser();
            $user = new EntitieUser([
                'id_user' => $id_user
            ]);

            if ($modelUser->deleteUser($user)) {
                $response = [
                    'errno' => 0,
                    'errmsg' => 'User deleted successfully',
                    'data' => [
                        'id_user' => $id_user
                    ]
                ];
            } else {
                $response['errmsg'] = 'Failed to delete user';
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}
