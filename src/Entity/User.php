<?php

namespace EyoPHP\Framework\Entity;

/**
 * User Entity - Représente un utilisateur du système
 *
 * @package EyoPHP\Framework\Entity
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */
class User
{
    private int $id_user = 0;
    private string $nickName = '';
    private string $email = '';
    private string $password = '';
    private string $created_at = '';
    private string $updated_at = '';
    private int $id_role = 0;

    /**
     * Constructeur pour hydrater les données à partir d'un tableau
     */
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    /**
     * Méthode pour hydrater l'objet avec les données
     */
    public function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            $method = "set" . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * Get the value of id_user
     */
    public function getId_user(): int
    {
        return $this->id_user;
    }

    /**
     * Set the value of id_user
     */
    public function setId_user($id_user): self
    {
        $this->id_user = (int) $id_user;
        return $this;
    }

    /**
     * Get the value of nickname
     */
    public function getNickName(): string
    {
        return $this->nickName;
    }

    /**
     * Set the value of nickname
     */
    public function setNickName($nickName): self
    {
        $this->nickName = (string) $nickName;
        return $this;
    }

    /**
     * Get the value of mail
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of mail
     */
    public function setEmail($email): self
    {
        $this->email = (string) $email;
        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword($password): self
    {
        $this->password = (string) $password;
        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreated_at(): string
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     */
    public function setCreated_at($created_at): self
    {
        $this->created_at = (string) $created_at;
        return $this;
    }

    /**
     * Get the value of updated_at
     */
    public function getUpdated_at(): string
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     */
    public function setUpdated_at($updated_at): self
    {
        $this->updated_at = (string) $updated_at;
        return $this;
    }

    /**
     * Get the value of id_role
     */
    public function getId_role(): int
    {
        return $this->id_role;
    }

    /**
     * Set the value of id_role
     */
    public function setId_role($id_role): self
    {
        $this->id_role = (int) $id_role;
        return $this;
    }

    /**
     * Utility methods
     */

    /**
     * Check if user has admin role (id_role = 3)
     */
    public function isAdmin(): bool
    {
        return $this->getId_role() === 3;
    }

    /**
     * Check if user has moderator role (id_role = 2)
     */
    public function isModerator(): bool
    {
        return $this->getId_role() === 2;
    }

    /**
     * Check if user has specific role by ID
     */
    public function hasRoleId(int $roleId): bool
    {
        return $this->getId_role() === $roleId;
    }

    /**
     * Get user display name (nickname)
     */
    public function getDisplayName(): string
    {
        return $this->getNickname();
    }

    /**
     * Convert entity to array (useful for JSON responses)
     */
    public function toArray(bool $includePassword = false): array
    {
        $data = [
            'id_user' => $this->getId_user(),
            'nickname' => $this->getNickname(),
            'mail' => $this->getEmail(),
            'created_at' => $this->getCreated_at(),
            'updated_at' => $this->getUpdated_at(),
            'id_role' => $this->getId_role()
        ];

        if ($includePassword) {
            $data['password'] = $this->getPassword();
        }

        return $data;
    }
}
