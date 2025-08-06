<?php

/**
 * Aliases pour la rétrocompatibilité avec l'ancienne structure
 * 
 * Ce fichier permet d'utiliser les nouveaux namespaces avec les anciens noms de classes
 */

// Entités
class_alias(\EyoPHP\Framework\Entity\User::class, 'EntitieUser');

// Modèles
class_alias(\EyoPHP\Framework\Model\UserModel::class, 'ModelUser');

// Contrôleurs
class_alias(\EyoPHP\Framework\Controller\ErrorController::class, 'ControllerError');

// Exceptions (éviter les conflits avec les anciennes classes)
if (!class_exists('ClassNotFoundException')) {
    class_alias(\EyoPHP\Framework\Exception\ClassNotFoundException::class, 'ClassNotFoundException');
}

// Classes Core (si pas encore migrées)
class_alias(\EyoPHP\Framework\Core\LegacyDatabase::class, 'ClassDatabase');

if (class_exists(\EyoPHP\Framework\Core\Router::class)) {
    class_alias(\EyoPHP\Framework\Core\Router::class, 'ClassRouter');
}
