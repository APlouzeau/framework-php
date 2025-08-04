<?php

class ClassValidator
{
    public static function verifyEmail(string $email): array
    {
        if (empty($email)) {
            return [
                'code' => 0,
                'message' => 'L\'email ne peut pas être vide',
            ];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'code' => 0,
                'message' => 'L\'email n\'est pas valide',
            ];
        }

        return [
            'code' => 1,
            'message' => 'L\'email est valide',
        ];
    }

    public static function verifyNickName(string $nickName): array
    {
        // Validation de la longueur
        if (strlen($nickName) < 2) {
            return [
                'code' => 0,
                'message' => 'Le pseudonyme doit contenir au moins 2 caractères',
            ];
        }

        if (strlen($nickName) > 25) {
            return [
                'code' => 0,
                'message' => 'Le pseudonyme doit contenir moins de 25 caractères',
            ];
        }

        // Validation du format
        if (!preg_match('/^\w+$/', $nickName)) {
            return [
                'code' => 0,
                'message' => 'Le pseudonyme ne peut contenir que des lettres, des chiffres et des underscores (_).',
            ];
        }

        return [
            'code' => 1,
            'message' => 'Le pseudonyme est valide',
        ];
    }

    public static function verifyPasswordFormat(string $password): array
    {
        $regex = "/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,60})/";
        if (!preg_match($regex, $password)) {
            return [
                'code' => 0,
                'message' => 'Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
            ];
        }

        return [
            'code' => 1,
            'message' => 'Mot de passe valide',
        ];
    }

    /**
     * Valide que deux champs sont identiques (ex: confirmation mot de passe)
     */
    public static function verifyMatch(string $field1, string $field2, string $fieldName = 'champ'): array
    {
        if ($field1 !== $field2) {
            return [
                'code' => 0,
                'message' => "Les {$fieldName}s ne correspondent pas",
            ];
        }

        return [
            'code' => 1,
            'message' => "Les {$fieldName}s correspondent",
        ];
    }

    /**
     * Valide plusieurs champs en une fois
     */
    public static function validateMultiple(array $validations): array
    {
        $errors = [];
        $isValid = true;

        foreach ($validations as $fieldName => $result) {
            if ($result['code'] === 0) {
                $errors[$fieldName] = $result['message'];
                $isValid = false;
            }
        }

        return [
            'code' => $isValid ? 1 : 0,
            'message' => $isValid ? 'Toutes les validations sont passées' : 'Des erreurs ont été trouvées',
            'errors' => $errors
        ];
    }

    /**
     * Valide qu'un champ n'est pas vide
     */
    public static function verifyNotEmpty(string $value, string $fieldName = 'champ'): array
    {
        if (empty(trim($value))) {
            return [
                'code' => 0,
                'message' => "Le {$fieldName} ne peut pas être vide",
            ];
        }

        return [
            'code' => 1,
            'message' => "Le {$fieldName} est valide",
        ];
    }

    /**
     * Valide la longueur d'une chaîne
     */
    public static function verifyLength(string $value, int $min, int $max, string $fieldName = 'champ'): array
    {
        $length = strlen($value);

        if ($length < $min) {
            return [
                'code' => 0,
                'message' => "Le {$fieldName} doit contenir au moins {$min} caractères",
            ];
        }

        if ($length > $max) {
            return [
                'code' => 0,
                'message' => "Le {$fieldName} doit contenir moins de {$max} caractères",
            ];
        }

        return [
            'code' => 1,
            'message' => "Le {$fieldName} est valide",
        ];
    }
}
