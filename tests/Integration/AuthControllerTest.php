<?php

namespace EyoPHP\Framework\Tests\Integration;

use PHPUnit\Framework\TestCase;
use EyoPHP\Framework\Validation\Validator;
use EyoPHP\Framework\Entity\User;

/**
 * Tests d'intégration pour AuthController
 * 
 * @package EyoPHP\Framework\Tests\Integration
 * @author  Alexandre PLOUZEAU
 * @covers \EyoPHP\Framework\Controller\AuthController
 */
class AuthControllerTest extends TestCase
{
    /**
     * Test de validation des données d'inscription valides
     */
    public function testValidRegistrationData(): void
    {
        // Données valides d'inscription
        $postData = [
            'nickName' => 'alex_dev',
            'email' => 'alex@eyophp.com',
            'password' => 'SecurePass123!',
            'confirmPassword' => 'SecurePass123!'
        ];

        // Règles de validation comme dans AuthController
        $rules = [
            'nickName' => [['required']],
            'email' => [['required'], ['email']],
            'password' => [['required'], ['password'], ['length', 8, 20]],
            'confirmPassword' => [['required'], ['match', 'password']],
        ];

        $validation = Validator::validateForm($postData, $rules);

        $this->assertTrue($validation['valid'], 'Les données valides doivent passer la validation');
        $this->assertEmpty($validation['errors'], 'Aucune erreur ne doit être présente');
    }

    /**
     * Test de validation des données d'inscription invalides
     */
    public function testInvalidRegistrationData(): void
    {
        // Données invalides d'inscription
        $postData = [
            'nickName' => '',                    // Vide (requis)
            'email' => 'email-invalide',         // Format invalide
            'password' => '123',                 // Trop court
            'confirmPassword' => '456'           // Ne correspond pas
        ];

        // Règles de validation comme dans AuthController
        $rules = [
            'nickName' => [['required']],
            'email' => [['required'], ['email']],
            'password' => [['required'], ['password'], ['length', 8, 20]],
            'confirmPassword' => [['required'], ['match', 'password']],
        ];

        $validation = Validator::validateForm($postData, $rules);

        $this->assertFalse($validation['valid'], 'Les données invalides ne doivent pas passer la validation');
        $this->assertNotEmpty($validation['errors'], 'Des erreurs doivent être présentes');

        // Vérifier que tous les champs ont des erreurs
        $this->assertArrayHasKey('nickName', $validation['errors']);
        $this->assertArrayHasKey('email', $validation['errors']);
        $this->assertArrayHasKey('password', $validation['errors']);
        $this->assertArrayHasKey('confirmPassword', $validation['errors']);
    }

    /**
     * Test de création d'entité User avec les données du formulaire
     */
    public function testUserEntityCreation(): void
    {
        $postData = [
            'nickName' => 'alex_dev',
            'email' => 'alex@eyophp.com',
            'password' => 'SecurePass123!',
        ];

        // Test de création d'un User comme dans AuthController
        $user = new User([
            'nickName' => $postData['nickName'],
            'email' => $postData['email'],
            'password' => password_hash($postData['password'], PASSWORD_BCRYPT),
            'id_role' => 1
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($postData['nickName'], $user->getNickName());
        $this->assertEquals($postData['email'], $user->getEmail());
        $this->assertEquals(1, $user->getId_role());

        // Vérifier que le mot de passe est bien haché
        $this->assertNotEquals($postData['password'], $user->getPassword());
        $this->assertTrue(password_verify($postData['password'], $user->getPassword()));
    }

    /**
     * Test des types de champs requis pour l'inscription
     */
    public function testRequiredFieldsValidation(): void
    {
        $rules = [
            'nickName' => [['required']],
            'email' => [['required'], ['email']],
            'password' => [['required'], ['password'], ['length', 8, 20]],
            'confirmPassword' => [['required'], ['match', 'password']],
        ];

        // Test avec tous les champs vides
        $emptyData = [
            'nickName' => '',
            'email' => '',
            'password' => '',
            'confirmPassword' => ''
        ];

        $validation = Validator::validateForm($emptyData, $rules);

        $this->assertFalse($validation['valid']);
        $this->assertCount(4, $validation['errors'], 'Tous les champs requis doivent générer des erreurs');
    }

    /**
     * Test de la cohérence des mots de passe
     */
    public function testPasswordConfirmationValidation(): void
    {
        $rules = [
            'password' => [['required'], ['password'], ['length', 8, 20]],
            'confirmPassword' => [['required'], ['match', 'password']],
        ];

        // Test avec mots de passe différents
        $mismatchData = [
            'password' => 'MotDePasse123!',
            'confirmPassword' => 'AutreMotDePasse123!'
        ];

        $validation = Validator::validateForm($mismatchData, $rules);

        $this->assertFalse($validation['valid']);
        $this->assertArrayHasKey('confirmPassword', $validation['errors']);
        $this->assertStringContainsString('ne correspond pas', $validation['errors']['confirmPassword'][0]);
    }

    /**
     * Test de validation des emails avec différents formats
     */
    public function testEmailFormatValidation(): void
    {
        $rules = [
            'email' => [['required'], ['email']],
        ];

        $validEmails = [
            'test@example.com',
            'user.name@domain.co.uk',
            'user+tag@example.org',
        ];

        $invalidEmails = [
            'invalid-email',
            '@example.com',
            'user@',
            'user name@example.com',
        ];

        // Test emails valides
        foreach ($validEmails as $email) {
            $validation = Validator::validateForm(['email' => $email], $rules);
            $this->assertTrue($validation['valid'], "L'email '$email' devrait être valide");
        }

        // Test emails invalides
        foreach ($invalidEmails as $email) {
            $validation = Validator::validateForm(['email' => $email], $rules);
            $this->assertFalse($validation['valid'], "L'email '$email' devrait être invalide");
        }
    }

    /**
     * Test de robustesse des mots de passe
     */
    public function testPasswordStrengthValidation(): void
    {
        $rules = [
            'password' => [['required'], ['password'], ['length', 8, 20]],
        ];

        $weakPasswords = [
            'password',          // Pas de majuscule ni chiffre
            'PASSWORD',          // Pas de minuscule ni chiffre
            '12345678',          // Pas de lettre
            'Pass1',             // Trop court
            'pass1',             // Pas de majuscule
        ];

        $strongPasswords = [
            'MotDePasse123',
            'SecurePass456!',
            'MyPassword789',
        ];

        // Test mots de passe faibles
        foreach ($weakPasswords as $password) {
            $validation = Validator::validateForm(['password' => $password], $rules);
            $this->assertFalse($validation['valid'], "Le mot de passe '$password' devrait être rejeté");
        }

        // Test mots de passe forts
        foreach ($strongPasswords as $password) {
            $validation = Validator::validateForm(['password' => $password], $rules);
            $this->assertTrue($validation['valid'], "Le mot de passe '$password' devrait être accepté");
        }
    }
}
