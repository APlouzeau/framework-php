-- =============================================
-- Script SQL pour EyoPHP Framework
-- Création de la table Users avec système d'authentification
-- =============================================

-- Création de la base de données (optionnel)
-- CREATE DATABASE IF NOT EXISTS eyophp_starter CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE eyophp_starter;

-- Table des rôles
CREATE TABLE IF NOT EXISTS roles (
    id_role INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_name (name)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nickname VARCHAR(50) NOT NULL UNIQUE,
    mail VARCHAR(100) DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    id_role INT NOT NULL DEFAULT 1,
    
    INDEX idx_nickname (nickname),
    INDEX idx_mail (mail),
    INDEX idx_role (id_role),
    
    FOREIGN KEY (id_role) REFERENCES roles(id_role) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- =============================================
-- Données de référence : Rôles
-- =============================================

INSERT INTO roles (id_role, name, description) VALUES 
(1, 'user', 'Utilisateur standard avec accès de base'),
(2, 'moderator', 'Modérateur avec droits de modération'),
(3, 'admin', 'Administrateur avec tous les droits');

-- =============================================
-- Données de test et comptes par défaut
-- =============================================

-- Utilisateur admin par défaut (mot de passe: admin123)
-- Hash généré avec: password_hash('admin123', PASSWORD_BCRYPT)
INSERT INTO users (nickname, mail, password, id_role) VALUES 
('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3);

-- Utilisateur moderateur (mot de passe: mod123)
INSERT INTO users (nickname, mail, password, id_role) VALUES 
('moderator', 'mod@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2);

-- Utilisateur standard (mot de passe: user123)
INSERT INTO users (nickname, mail, password, id_role) VALUES 
('testuser', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

-- Autre utilisateur standard pour tester les listes
INSERT INTO users (nickname, mail, password, id_role) VALUES 
('alice', 'alice@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

-- =============================================
-- Vérification de l'installation
-- =============================================
SELECT 'Installation réussie!' as message, COUNT(*) as users_created FROM users;

-- Affichage des comptes créés par rôle
SELECT 
    r.name as role,
    COUNT(u.id_user) as user_count,
    GROUP_CONCAT(u.nickname SEPARATOR ', ') as users
FROM roles r 
LEFT JOIN users u ON r.id_role = u.id_role
GROUP BY r.id_role, r.name 
ORDER BY r.id_role;
