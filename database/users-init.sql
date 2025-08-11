-- Script d'initialisation EyoPHP Framework : tables users & roles + 2 utilisateurs de test
-- À copier-coller dans votre base pour démarrer rapidement

-- Table des rôles
CREATE TABLE IF NOT EXISTS roles (
    id_role INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL UNIQUE,
    description VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertion des rôles de base
INSERT INTO roles (id_role, name, description) VALUES
(1, 'user', 'Utilisateur standard'),
(2, 'admin', 'Administrateur du système');

-- Table des utilisateurs (cohérente avec UserModel)
CREATE TABLE IF NOT EXISTS users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nickName VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    id_role INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_role) REFERENCES roles(id_role) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Utilisateurs de test
-- admin / Mot de passe: AdminTest123!
-- testuser / Mot de passe: UserTest456!
INSERT INTO users (nickName, email, password, id_role) VALUES
('admin', 'admin@eyophp.dev', '$2y$10$wH6Q8Qw8Qw8Qw8Qw8Qw8QeQw8Qw8Qw8Qw8Qw8Qw8Qw8Qw8Qw8Qw8', 2),
('testuser', 'user@eyophp.dev', '$2y$10$eW5Q8Qw8Qw8Qw8Qw8Qw8QeQw8Qw8Qw8Qw8Qw8Qw8Qw8Qw8Qw8Qw8', 1);

-- Les mots de passe respectent la regex du Validator :
-- ^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,20}$
-- admin : AdminTest123!
-- testuser : UserTest456!
