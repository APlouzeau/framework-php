<?php

/**
 * ClassTranslation - Système de traduction simple pour EyoPHP
 *
 * Gère les messages d'erreur et textes utilisateur en français
 * tout en gardant le code en anglais
 *
 * @package EyoPHP\Framework
 * @author  Alexandre PLOUZEAU
 * @version 1.0.0
 */
class ClassTranslation
{
    /**
     * Messages de validation en français
     */
    private static array $messages = [
        'validation' => [
            'email' => [
                'empty' => 'L\'adresse email ne peut pas être vide',
                'invalid' => 'L\'adresse email n\'est pas valide',
                'valid' => 'L\'adresse email est valide',
            ],
            'nickname' => [
                'empty' => 'Le pseudo ne peut pas être vide',
                'too_short' => 'Le pseudo doit contenir au moins 3 caractères',
                'too_long' => 'Le pseudo ne peut pas dépasser 50 caractères',
                'valid' => 'Le pseudo est valide',
            ],
            'password' => [
                'empty' => 'Le mot de passe ne peut pas être vide',
                'too_short' => 'Le mot de passe doit contenir au moins 6 caractères',
                'valid' => 'Le mot de passe est valide',
            ],
            'field' => [
                'empty' => 'Le champ :field ne peut pas être vide',
                'too_short' => 'Le champ :field doit contenir au moins :min caractères',
                'too_long' => 'Le champ :field ne peut pas dépasser :max caractères',
                'mismatch' => 'Les champs :field ne correspondent pas',
                'valid' => 'Le champ :field est valide',
            ],
        ],

        'auth' => [
            'login.success' => 'Connexion réussie',
            'login.failed' => 'Identifiants incorrects',
            'logout.success' => 'Déconnexion réussie',
            'register.success' => 'Inscription réussie',
            'register.failed' => 'Erreur lors de l\'inscription',
        ],

        'errors' => [
            'page.not_found' => 'Page non trouvée',
            'internal_error' => 'Erreur interne du serveur',
            'access_denied' => 'Accès refusé',
        ]
    ];

    /**
     * Récupérer un message traduit
     *
     * @param string $key Clé du message (ex: 'validation.email.invalid')
     * @param array $replacements Variables à remplacer dans le message
     *
     * @return string Message traduit
     */
    public static function get(string $key, array $replacements = []): string
    {
        $keys = explode('.', $key);
        $message = self::$messages;

        foreach ($keys as $keyPart) {
            if (!isset($message[$keyPart])) {
                return "Message non trouvé: {$key}";
            }
            $message = $message[$keyPart];
        }

        // Remplacer les variables (:field, :min, :max, etc.)
        foreach ($replacements as $placeholder => $value) {
            $message = str_replace(":{$placeholder}", $value, $message);
        }

        return $message;
    }

    /**
     * Alias pour get() - plus court à utiliser
     */
    public static function t(string $key, array $replacements = []): string
    {
        return self::get($key, $replacements);
    }
}
