<?php

/**
 * ClassValidator - Classe de validation des données
 *
 * Cette classe fournit des méthodes statiques pour valider différents types de données
 * utilisées dans l'application EyoPHP (emails, mots de passe, pseudos, etc.)
 * Code en anglais, messages en français via Translation
 *
 * @package EyoPHP\Framework
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0 (refactorisé avec noms anglais + traduction)
 * @since   1.0.0
 */
class ClassValidator
{
    /**
     * Valide une adresse email
     *
     * Vérifie qu'une adresse email est valide selon les standards RFC
     *
     * @param string $email L'adresse email à valider
     *
     * @return array Tableau avec 'code' (0|1) et 'message' (string)
     *               - code: 1 si valide, 0 si invalide
     *               - message: Message descriptif du résultat
     *
     * @example
     * ```php
     * $result = ClassValidator::validateEmail('user@example.com');
     * if ($result['code']) {
     *     echo "Email valide !";
     * }
     * ```
     *
     * @since 1.0.0
     */
    public static function validateEmail(string $email): array
    {
        if (empty($email)) {
            return [
                'code' => 0,
                'message' => ClassTranslation::get('validation.email.empty'),
            ];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'code' => 0,
                'message' => ClassTranslation::get('validation.email.invalid'),
            ];
        }

        return [
            'code' => 1,
            'message' => ClassTranslation::get('validation.email.valid'),
        ];
    }

    /**
     * Valide un pseudonyme utilisateur
     *
     * Vérifie qu'un pseudo respecte les critères : 3-50 caractères
     *
     * @param string $nickname Le pseudonyme à valider
     *
     * @return array Tableau avec 'code' (0|1) et 'message' (string)
     *
     * @since 1.0.0
     */
    public static function validateNickname(string $nickname): array
    {
        if (empty($nickname)) {
            return [
                'code' => 0,
                'message' => ClassTranslation::get('validation.nickname.empty'),
            ];
        }

        if (strlen($nickname) < 3) {
            return [
                'code' => 0,
                'message' => ClassTranslation::get('validation.nickname.too_short'),
            ];
        }

        if (strlen($nickname) > 50) {
            return [
                'code' => 0,
                'message' => ClassTranslation::get('validation.nickname.too_long'),
            ];
        }

        return [
            'code' => 1,
            'message' => ClassTranslation::get('validation.nickname.valid'),
        ];
    }

    /**
     * Valide le format d'un mot de passe
     *
     * Vérifie qu'un mot de passe respecte les critères de sécurité
     *
     * @param string $password Le mot de passe à valider
     *
     * @return array Tableau avec 'code' (0|1) et 'message' (string)
     *
     * @since 1.0.0
     */
    public static function validatePasswordFormat(string $password): array
    {
        if (empty($password)) {
            return [
                'code' => 0,
                'message' => ClassTranslation::get('validation.password.empty'),
            ];
        }

        if (strlen($password) < 6) {
            return [
                'code' => 0,
                'message' => ClassTranslation::get('validation.password.too_short'),
            ];
        }

        return [
            'code' => 1,
            'message' => ClassTranslation::get('validation.password.valid'),
        ];
    }

    /**
     * Vérifie que deux champs correspondent
     *
     * @param string $field1 Premier champ
     * @param string $field2 Deuxième champ
     * @param string $fieldName Nom du champ pour le message d'erreur
     *
     * @return array Tableau avec 'code' (0|1) et 'message' (string)
     *
     * @since 1.0.0
     */
    public static function validateMatch(string $field1, string $field2, string $fieldName = 'mot de passe'): array
    {
        if ($field1 !== $field2) {
            return [
                'code' => 0,
                'message' => ClassTranslation::get('validation.field.mismatch', ['field' => $fieldName]),
            ];
        }

        return [
            'code' => 1,
            'message' => ClassTranslation::get('validation.field.valid', ['field' => $fieldName]),
        ];
    }

    /**
     * Vérifie qu'un champ n'est pas vide
     *
     * @param string $value Valeur à vérifier
     * @param string $fieldName Nom du champ pour le message d'erreur
     *
     * @return array Tableau avec 'code' (0|1) et 'message' (string)
     *
     * @since 1.0.0
     */
    public static function validateNotEmpty(string $value, string $fieldName = 'champ'): array
    {
        if (empty(trim($value))) {
            return [
                'code' => 0,
                'message' => ClassTranslation::get('validation.field.empty', ['field' => $fieldName]),
            ];
        }

        return [
            'code' => 1,
            'message' => ClassTranslation::get('validation.field.valid', ['field' => $fieldName]),
        ];
    }

    /**
     * Vérifie la longueur d'un champ
     *
     * @param string $value Valeur à vérifier
     * @param int $min Longueur minimale
     * @param int $max Longueur maximale
     * @param string $fieldName Nom du champ pour le message d'erreur
     *
     * @return array Tableau avec 'code' (0|1) et 'message' (string)
     *
     * @since 1.0.0
     */
    public static function validateLength(string $value, int $min, int $max, string $fieldName = 'champ'): array
    {
        $length = strlen($value);

        if ($length < $min) {
            return [
                'code' => 0,
                'message' => ClassTranslation::get('validation.field.too_short', [
                    'field' => $fieldName,
                    'min' => $min
                ]),
            ];
        }

        if ($length > $max) {
            return [
                'code' => 0,
                'message' => ClassTranslation::get('validation.field.too_long', [
                    'field' => $fieldName,
                    'max' => $max
                ]),
            ];
        }

        return [
            'code' => 1,
            'message' => ClassTranslation::get('validation.field.valid', ['field' => $fieldName]),
        ];
    }

    // ========================================
    // MÉTHODES DE RÉTROCOMPATIBILITÉ
    // @deprecated - Utilisez les méthodes validate*() à la place
    // ========================================

    /**
     * @deprecated Utilisez validateEmail() à la place
     * @see validateEmail()
     */
    public static function verifyEmail(string $email): array
    {
        return self::validateEmail($email);
    }

    /**
     * @deprecated Utilisez validateNickname() à la place
     * @see validateNickname()
     */
    public static function verifyNickName(string $nickName): array
    {
        return self::validateNickname($nickName);
    }

    /**
     * @deprecated Utilisez validatePasswordFormat() à la place
     * @see validatePasswordFormat()
     */
    public static function verifyPasswordFormat(string $password): array
    {
        return self::validatePasswordFormat($password);
    }

    /**
     * @deprecated Utilisez validateMatch() à la place
     * @see validateMatch()
     */
    public static function verifyMatch(string $field1, string $field2, string $fieldName = 'champ'): array
    {
        return self::validateMatch($field1, $field2, $fieldName);
    }

    /**
     * @deprecated Utilisez validateNotEmpty() à la place
     * @see validateNotEmpty()
     */
    public static function verifyNotEmpty(string $value, string $fieldName = 'champ'): array
    {
        return self::validateNotEmpty($value, $fieldName);
    }

    /**
     * @deprecated Utilisez validateLength() à la place
     * @see validateLength()
     */
    public static function verifyLength(string $value, int $min, int $max, string $fieldName = 'champ'): array
    {
        return self::validateLength($value, $min, $max, $fieldName);
    }
}
