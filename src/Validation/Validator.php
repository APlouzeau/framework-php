<?php

namespace EyoPHP\Framework\Validation;

/**
 * Validator - Data validation class
 *
 * This class provides static methods to validate different types of data
 * used in EyoPHP application (emails, passwords, usernames, etc.)
 *
 * @package EyoPHP\Framework\Validation
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */
class Validator
{
    /**
     * Traduit les noms de champs techniques vers des libellés plus lisibles
     */
    private static function getFieldLabel(string $fieldName): string
    {
        $labels = [
            'password' => 'mot de passe',
            'confirmPassword' => 'mot de passe',  // Pour éviter la double confirmation
            'email' => 'email',
            'nickName' => 'nom d\'utilisateur',
            'firstName' => 'prénom',
            'lastName' => 'nom',
            'phone' => 'téléphone',
            'address' => 'adresse',
            'city' => 'ville',
            'postalCode' => 'code postal',
        ];

        return $labels[$fieldName] ?? $fieldName;
    }
    /**
     * Validate an email address
     *
     * Checks that an email address is valid according to RFC standards
     *
     * @param string $email The email address to validate
     * @return array Array with 'code' (0|1) and 'message' (string)
     */
    public static function validateEmail(string $email): array
    {
        if (empty($email)) {
            return [
                'code' => 0,
                'message' => 'L\'adresse email ne peut pas être vide.',
            ];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'code' => 0,
                'message' => 'L\'adresse email n\'est pas valide.',
            ];
        }

        return [
            'code' => 1,
            'message' => 'L\'adresse email est valide.',
        ];
    }

    /**
     * Valide un pseudonyme utilisateur
     *
     * Vérifie qu'un pseudo respecte les critères : 3-50 caractères
     *
     * @param string $nickname Le pseudonyme à valider
     * @return array Tableau avec 'code' (0|1) et 'message' (string)
     */
    public static function validateNickname(string $nickname): array
    {
        if (empty($nickname)) {
            return [
                'code' => 0,
                'message' => 'Le pseudonyme ne peut pas être vide.',
            ];
        }

        if (strlen($nickname) < 3) {
            return [
                'code' => 0,
                'message' => 'Le pseudonyme doit contenir au moins 3 caractères.',
            ];
        }

        if (strlen($nickname) > 50) {
            return [
                'code' => 0,
                'message' => 'Le pseudonyme ne peut pas dépasser 50 caractères.',
            ];
        }

        return [
            'code' => 1,
            'message' => 'Le pseudonyme est valide.',
        ];
    }

    /**
     * Valide le format d'un mot de passe
     *
     * Vérifie les critères de sécurité : longueur, complexité
     *
     * @param string $password Le mot de passe à valider
     * @return array Tableau avec 'code' (0|1) et 'message' (string)
     */
    public static function validatePasswordFormat(string $password): array
    {
        if (empty($password)) {
            return [
                'code' => 0,
                'message' => 'Le mot de passe ne peut pas être vide.',
            ];
        }

        if (!preg_match('/[A-Z]/', $password)) {
            return [
                'code' => 0,
                'message' => 'Le mot de passe doit contenir au moins une lettre majuscule.',
            ];
        }

        if (!preg_match('/[a-z]/', $password)) {
            return [
                'code' => 0,
                'message' => 'Le mot de passe doit contenir au moins une lettre minuscule.',
            ];
        }

        if (!preg_match('/[0-9]/', $password)) {
            return [
                'code' => 0,
                'message' => 'Le mot de passe doit contenir au moins un chiffre.',
            ];
        }

        return [
            'code' => 1,
            'message' => 'Le mot de passe respecte les critères de sécurité.',
        ];
    }

    /**
     * Valide que deux champs correspondent
     *
     * @param string $field1 Premier champ
     * @param string $field2 Deuxième champ
     * @param string $fieldName Nom du champ pour le message
     * @return array Tableau avec 'code' (0|1) et 'message' (string)
     */
    public static function validateMatch(string $field1, string $field2, string $fieldName = 'mot de passe'): array
    {
        $label = self::getFieldLabel($fieldName);

        if ($field1 !== $field2) {
            return [
                'code' => 0,
                'message' => "La confirmation du {$label} ne correspond pas.",
            ];
        }

        return [
            'code' => 1,
            'message' => "Les {$label}s correspondent.",
        ];
    }

    /**
     * Valide qu'un champ n'est pas vide
     *
     * @param string $value Valeur à valider
     * @param string $fieldName Nom du champ pour le message
     * @return array Tableau avec 'code' (0|1) et 'message' (string)
     */
    public static function validateNotEmpty(string $value, string $fieldName = 'champ'): array
    {
        if (empty(trim($value))) {
            return [
                'code' => 0,
                'message' => "Le {$fieldName} ne peut pas être vide.",
            ];
        }

        return [
            'code' => 1,
            'message' => "Le {$fieldName} est valide.",
        ];
    }

    /**
     * Valide la longueur d'un champ
     *
     * @param string $value Valeur à valider
     * @param int $min Longueur minimum
     * @param int $max Longueur maximum
     * @param string $fieldName Nom du champ pour le message
     * @return array Tableau avec 'code' (0|1) et 'message' (string)
     */
    public static function validateLength(string $value, int $min, int $max = 128, string $fieldName = 'champ'): array
    {
        $length = strlen($value);
        $label = self::getFieldLabel($fieldName);

        if ($length < $min) {
            return [
                'code' => 0,
                'message' => "Le {$label} doit contenir au moins {$min} caractères.",
            ];
        }

        if ($length > $max) {
            return [
                'code' => 0,
                'message' => "Le {$label} ne peut pas dépasser {$max} caractères.",
            ];
        }

        return [
            'code' => 1,
            'message' => "Le {$label} respecte la longueur requise.",
        ];
    }

    /**
     * Valide un numéro de téléphone français
     *
     * @param string $phone Numéro de téléphone à valider
     * @return array Tableau avec 'code' (0|1) et 'message' (string)
     */
    public static function validatePhoneNumber(string $phone): array
    {
        if (empty($phone)) {
            return [
                'code' => 0,
                'message' => 'Le numéro de téléphone ne peut pas être vide.',
            ];
        }

        // Nettoyer le numéro (enlever espaces, tirets, points)
        $cleanPhone = preg_replace('/[\s\-\.]/', '', $phone);

        // Vérifier le format français
        if (!preg_match('/^(?:\+33|0)[1-9](?:[0-9]{8})$/', $cleanPhone)) {
            return [
                'code' => 0,
                'message' => 'Le numéro de téléphone n\'est pas valide.',
            ];
        }

        return [
            'code' => 1,
            'message' => 'Le numéro de téléphone est valide.',
        ];
    }

    /**
     * Valide une URL
     *
     * @param string $url URL à valider
     * @return array Tableau avec 'code' (0|1) et 'message' (string)
     */
    public static function validateUrl(string $url): array
    {
        if (empty($url)) {
            return [
                'code' => 0,
                'message' => 'L\'URL ne peut pas être vide.',
            ];
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return [
                'code' => 0,
                'message' => 'L\'URL n\'est pas valide.',
            ];
        }

        return [
            'code' => 1,
            'message' => 'L\'URL est valide.',
        ];
    }

    /**
     * Valide un code postal français
     *
     * @param string $postalCode Code postal à valider
     * @return array Tableau avec 'code' (0|1) et 'message' (string)
     */
    public static function validatePostalCode(string $postalCode): array
    {
        if (empty($postalCode)) {
            return [
                'code' => 0,
                'message' => 'Le code postal ne peut pas être vide.',
            ];
        }

        if (!preg_match('/^[0-9]{5}$/', $postalCode)) {
            return [
                'code' => 0,
                'message' => 'Le code postal doit contenir exactement 5 chiffres.',
            ];
        }

        return [
            'code' => 1,
            'message' => 'Le code postal est valide.',
        ];
    }

    /**
     * Valide un formulaire complet
     *
     * @param array $data Données à valider
     * @param array $rules Règles de validation par champ
     * @return array Résultat de validation avec erreurs
     */
    public static function validateForm(array $data, array $rules): array
    {
        $errors = [];
        $isValid = true;

        foreach ($rules as $fieldName => $fieldRules) {
            $value = $data[$fieldName] ?? '';

            foreach ($fieldRules as $rule) {
                $result = null;

                // Extraire le type de règle (premier élément du tableau ou string)
                if (is_array($rule)) {
                    $ruleType = $rule[0] ?? '';
                    $ruleParams = array_slice($rule, 1);
                } else {
                    $ruleType = $rule;
                    $ruleParams = [];
                }

                switch ($ruleType) {
                    case 'required':
                        $result = self::validateNotEmpty($value, $fieldName);
                        break;

                    case 'email':
                        $result = self::validateEmail($value);
                        break;

                    case 'length':
                        $min = $ruleParams[0] ?? 1;
                        $max = $ruleParams[1] ?? 128;
                        $result = self::validateLength($value, $min, $max, $fieldName);
                        break;

                    case 'password':
                        $result = self::validatePasswordFormat($value);
                        break;

                    case 'match':
                        $otherField = $ruleParams[0] ?? '';
                        $otherValue = $data[$otherField] ?? '';
                        $result = self::validateMatch($value, $otherValue, $fieldName);
                        break;

                    default:
                        $result = [
                            'code' => 0,
                            'message' => "Règle de validation inconnue: {$ruleType}",
                        ];
                }

                if ($result && $result['code'] === 0) {
                    $errors[$fieldName][] = $result['message'];
                    $isValid = false;
                }
            }
        }

        return [
            'valid' => $isValid,
            'errors' => $errors
        ];
    }
}
