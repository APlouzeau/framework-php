-- =============================================
-- EyoPHP Framework - Base de données utilisateurs
-- Version: 1.0.0
-- Description: Structure de base pour l'authentification
-- =============================================

-- Création de la base de données (optionnel)
-- CREATE DATABASE IF NOT EXISTS eyophp_framework DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE eyophp_framework;

-- =============================================
-- Table: users
-- Description: Gestion des utilisateurs du framework
-- =============================================

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nickName` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_role` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `nickName` (`nickName`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: roles (optionnel pour extension future)
-- Description: Gestion des rôles utilisateurs
-- =============================================

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_role`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Données de test
-- =============================================

-- Insertion des rôles de base
INSERT INTO `roles` (`id_role`, `name`, `description`) VALUES
(1, 'user', 'Utilisateur standard'),
(2, 'admin', 'Administrateur du système'),
(3, 'moderator', 'Modérateur avec permissions étendues');

-- Insertion d'un utilisateur de test (mot de passe: "password123")
INSERT INTO `users` (`nickName`, `email`, `password`, `id_role`) VALUES
('admin', 'admin@eyophp.dev', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2),
('testuser', 'user@eyophp.dev', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

-- =============================================
-- Index et contraintes additionnelles
-- =============================================

-- Index pour optimiser les recherches
ALTER TABLE `users` ADD INDEX `idx_role` (`id_role`);
ALTER TABLE `users` ADD INDEX `idx_created_at` (`created_at`);

-- Contrainte de clé étrangère (optionnel)
-- ALTER TABLE `users` ADD CONSTRAINT `fk_users_roles` 
-- FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON DELETE RESTRICT ON UPDATE CASCADE;
