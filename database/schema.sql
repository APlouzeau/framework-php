-- Script de création de la base de données EyoPHP Framework
-- À exécuter après installation de MariaDB

-- Création de la base de données
CREATE DATABASE IF NOT EXISTS eyophp_framework CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE eyophp_framework;

-- Table des rôles
CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insertion des rôles par défaut
INSERT INTO roles (name, description) VALUES 
('user', 'Utilisateur standard'),
('admin', 'Administrateur du système');

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nickname VARCHAR(100) NOT NULL UNIQUE,
    mail VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    id_role INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_role) REFERENCES roles(id) ON DELETE SET NULL,
    INDEX idx_mail (mail),
    INDEX idx_nickname (nickname)
) ENGINE=InnoDB;

-- Utilisateur admin par défaut
INSERT INTO users (nickname, mail, password, id_role) VALUES 
('admin', 'admin@eyophp.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2);
-- Mot de passe: "password"

-- Table des sessions (optionnel pour plus tard)
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(128) PRIMARY KEY,
    user_id INT,
    data TEXT,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_last_activity (last_activity)
) ENGINE=InnoDB;
