<?php

namespace EyoPHP\Framework\Model;

use EyoPHP\Framework\Core\Database;
use EyoPHP\Framework\Entity\User;
use PDO;

/**
 * UserModel - User management in database
 *
 * @package EyoPHP\Framework\Model
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */
class UserModel
{
    /**
     * Get PDO connection
     */
    private function getConnection(): PDO
    {
        return Database::getInstance();
    }
    /**
     * Register a new user
     */
    public function register(User $user): bool
    {
        $query = "INSERT INTO users (nickName, email, password, id_role) VALUES (:nickName, :email, :password, :id_role)";
        $req = $this->getConnection()->prepare($query);

        $nickname = htmlspecialchars(strip_tags($user->getNickname()));
        $mail = htmlspecialchars(strip_tags($user->getEmail()));
        $password_hash = password_hash($user->getPassword(), PASSWORD_BCRYPT);
        $id_role = $user->getId_role() ?: 1; // Default to 'user' role

        $req->bindValue(":nickName", $nickname);
        $req->bindValue(":email", $mail);
        $req->bindValue(":password", $password_hash);
        $req->bindValue(":id_role", $id_role, PDO::PARAM_INT);

        return $req->execute();
    }

    /**
     * Get all users with role information
     */
    public function getAllUsers(): array
    {
        $query = "
            SELECT
                u.id_user, u.nickname, u.mail, u.created_at, u.updated_at, u.id_role,
                r.name as role_name, r.description as role_description
            FROM users u
            LEFT JOIN roles r ON u.id_role = r.id_role
            ORDER BY u.nickname ASC
        ";

        $req = $this->getConnection()->query($query);
        $datas = $req->fetchAll(PDO::FETCH_ASSOC);
        $users = [];

        foreach ($datas as $data) {
            $user = new User($data);
            $users[] = $user;
        }

        return $users;
    }

    /**
     * Login user authentication
     */
    public function login(User $userVerify): User|false
    {
        $query = "
            SELECT
                u.*,
                r.name as role_name,
                r.description as role_description
            FROM users u
            LEFT JOIN roles r ON u.id_role = r.id_role
            WHERE u.nickname = :nickname
        ";

        $req = $this->getConnection()->prepare($query);
        $req->bindValue(":nickname", $userVerify->getNickname());
        $req->execute();

        $user = $req->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify password using secure password_verify function
            if (password_verify($userVerify->getPassword(), $user['password'])) {
                return new User($user);
            } else {
                return false; // Incorrect password
            }
        } else {
            return false; // User not found
        }
    }

    /**
     * Get user by ID with role information
     */
    public function getUser(User $user): ?User
    {
        $query = "
            SELECT
                u.*,
                r.name as role_name,
                r.description as role_description
            FROM users u
            LEFT JOIN roles r ON u.id_role = r.id_role
            WHERE u.id_user = :id_user
        ";

        $req = $this->getConnection()->prepare($query);
        $req->bindValue(":id_user", $user->getId_user(), PDO::PARAM_INT);
        $req->execute();

        $data = $req->fetch(PDO::FETCH_ASSOC);

        return $data ? new User($data) : null;
    }

    /**
     * Get user by nickname with role information
     */
    public function getUserByNickname(string $nickname): ?User
    {
        $query = "
            SELECT
                u.*,
                r.name as role_name,
                r.description as role_description
            FROM users u
            LEFT JOIN roles r ON u.id_role = r.id_role
            WHERE u.nickname = :nickname
        ";

        $req = $this->getConnection()->prepare($query);
        $req->bindValue(":nickname", $nickname);
        $req->execute();

        $data = $req->fetch(PDO::FETCH_ASSOC);

        return $data ? new User($data) : null;
    }

    /**
     * Update user information
     */
    public function updateUser(User $user): bool
    {
        $query = "
            UPDATE users
            SET nickname = :nickname, mail = :mail, id_role = :id_role, updated_at = CURRENT_TIMESTAMP
            WHERE id_user = :id_user
        ";

        $req = $this->getConnection()->prepare($query);

        $nickname = htmlspecialchars(strip_tags($user->getNickname()));
        $mail = htmlspecialchars(strip_tags($user->getEmail()));
        $id_role = $user->getId_role();
        $id_user = $user->getId_user();

        $req->bindValue(":nickname", $nickname);
        $req->bindValue(":mail", $mail);
        $req->bindValue(":id_role", $id_role, PDO::PARAM_INT);
        $req->bindValue(":id_user", $id_user, PDO::PARAM_INT);

        return $req->execute();
    }

    /**
     * Update user password
     */
    public function updatePassword(User $user, string $newPassword): bool
    {
        $query = "UPDATE users SET password = :password, updated_at = CURRENT_TIMESTAMP WHERE id_user = :id_user";
        $req = $this->getConnection()->prepare($query);

        $password_hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $id_user = $user->getId_user();

        $req->bindValue(":password", $password_hash);
        $req->bindValue(":id_user", $id_user, PDO::PARAM_INT);

        return $req->execute();
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user): bool
    {
        $req = $this->getConnection()->prepare('DELETE FROM users WHERE id_user = :id_user');
        $req->bindValue(":id_user", $user->getId_user(), PDO::PARAM_INT);
        return $req->execute();
    }

    /**
     * Get users by role
     */
    public function getUsersByRole(string $roleName): array
    {
        $query = "
            SELECT
                u.*,
                r.name as role_name,
                r.description as role_description
            FROM users u
            INNER JOIN roles r ON u.id_role = r.id_role
            WHERE r.name = :role_name
            ORDER BY u.nickname ASC
        ";

        $req = $this->getConnection()->prepare($query);
        $req->bindValue(":role_name", $roleName);
        $req->execute();

        $datas = $req->fetchAll(PDO::FETCH_ASSOC);
        $users = [];

        foreach ($datas as $data) {
            $user = new User($data);
            $users[] = $user;
        }

        return $users;
    }

    /**
     * Check if data is available
     */
    public function isDataAvailable(string $field, string $value): bool
    {
        $allowedFields = ['email', 'nickName'];
        if (!in_array($field, $allowedFields, true)) {
            throw new \InvalidArgumentException('Champ non autorisé');
        }
        $req = $this->getConnection()->prepare("SELECT COUNT(*) FROM users WHERE $field = :value");
        $req->bindValue(":value", $value);

        $req->execute();

        return $req->fetchColumn() == 0;
    }
}
