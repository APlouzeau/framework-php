<?php

namespace EyoPHP\Framework\Tests\Unit;

use PHPUnit\Framework\TestCase;
use EyoPHP\Framework\Validation\Validator;

/**
 * Tests unitaires pour la classe Validator
 * 
 * @package EyoPHP\Framework\Tests\Unit
 * @author  Alexandre PLOUZEAU
 * @covers \EyoPHP\Framework\Validation\Validator
 */
class ValidatorTest extends TestCase
{
    /**
     * Test de validation d'email invalide
     */
    public function testValidateEmailInvalid(): void
    {
        $result = Validator::validateEmail('invalid-email');

        $this->assertEquals(0, $result['code']);
        $this->assertStringContainsString('email n\'est pas valide', $result['message']);
    }

    /**
     * Test de validation d'email valide
     */
    public function testValidateEmailValid(): void
    {
        $result = Validator::validateEmail('test@example.com');

        $this->assertEquals(1, $result['code']);
        $this->assertStringContainsString('email est valide', $result['message']);
    }

    /**
     * Test de validation d'email vide
     */
    public function testValidateEmailEmpty(): void
    {
        $result = Validator::validateEmail('');

        $this->assertEquals(0, $result['code']);
        $this->assertStringContainsString('ne peut pas être vide', $result['message']);
    }

    /**
     * Test de validation de mot de passe trop court
     */
    public function testValidatePasswordTooShort(): void
    {
        $result = Validator::validatePasswordFormat('123');

        $this->assertEquals(0, $result['code']);
        $this->assertStringContainsString('lettre majuscule', $result['message']);
    }

    /**
     * Test de validation de mot de passe valide
     */
    public function testValidatePasswordValid(): void
    {
        $result = Validator::validatePasswordFormat('MonMotDePasse123');

        $this->assertEquals(1, $result['code']);
        $this->assertStringContainsString('critères de sécurité', $result['message']);
    }

    /**
     * Test de validation de correspondance - échec
     */
    public function testValidateMatchFail(): void
    {
        $result = Validator::validateMatch('password1', 'password2', 'confirmPassword');

        $this->assertEquals(0, $result['code']);
        $this->assertStringContainsString('ne correspond pas', $result['message']);
    }

    /**
     * Test de validation de correspondance - succès
     */
    public function testValidateMatchSuccess(): void
    {
        $result = Validator::validateMatch('MonMotDePasse123', 'MonMotDePasse123', 'confirmPassword');

        $this->assertEquals(1, $result['code']);
        $this->assertStringContainsString('correspondent', $result['message']);
    }

    /**
     * Test de validation de longueur - trop court
     */
    public function testValidateLengthTooShort(): void
    {
        $result = Validator::validateLength('123', 5, 20, 'password');

        $this->assertEquals(0, $result['code']);
        $this->assertStringContainsString('au moins 5 caractères', $result['message']);
    }

    /**
     * Test de validation de longueur - trop long
     */
    public function testValidateLengthTooLong(): void
    {
        $result = Validator::validateLength(str_repeat('a', 25), 5, 20, 'password');

        $this->assertEquals(0, $result['code']);
        $this->assertStringContainsString('dépasser 20 caractères', $result['message']);
    }

    /**
     * Test de validation de longueur - valide
     */
    public function testValidateLengthValid(): void
    {
        $result = Validator::validateLength('MotDePasse', 5, 20, 'password');

        $this->assertEquals(1, $result['code']);
        $this->assertStringContainsString('respecte la longueur', $result['message']);
    }

    /**
     * Test de validation de formulaire avec données invalides
     */
    public function testValidateFormInvalid(): void
    {
        $data = [
            'nickName' => '',
            'email' => 'invalid-email',
            'password' => '123',
            'confirmPassword' => '456'
        ];

        $rules = [
            'nickName' => [['required']],
            'email' => [['required'], ['email']],
            'password' => [['required'], ['password'], ['length', 8, 20]],
            'confirmPassword' => [['required'], ['match', 'password']],
        ];

        $result = Validator::validateForm($data, $rules);

        $this->assertFalse($result['valid']);
        $this->assertArrayHasKey('errors', $result);
        $this->assertArrayHasKey('nickName', $result['errors']);
        $this->assertArrayHasKey('email', $result['errors']);
        $this->assertArrayHasKey('password', $result['errors']);
        $this->assertArrayHasKey('confirmPassword', $result['errors']);
    }

    /**
     * Test de validation de formulaire avec données valides
     */
    public function testValidateFormValid(): void
    {
        $data = [
            'nickName' => 'alex_dev',
            'email' => 'alex@eyophp.com',
            'password' => 'SecurePass123!',
            'confirmPassword' => 'SecurePass123!'
        ];

        $rules = [
            'nickName' => [['required']],
            'email' => [['required'], ['email']],
            'password' => [['required'], ['password'], ['length', 8, 20]],
            'confirmPassword' => [['required'], ['match', 'password']],
        ];

        $result = Validator::validateForm($data, $rules);

        $this->assertTrue($result['valid']);
        $this->assertEmpty($result['errors']);
    }

    /**
     * Test de validation avec champ manquant
     */
    public function testValidateFormMissingField(): void
    {
        $data = [
            'email' => 'test@example.com'
            // nickName manquant
        ];

        $rules = [
            'nickName' => [['required']],
            'email' => [['required'], ['email']],
        ];

        $result = Validator::validateForm($data, $rules);

        $this->assertFalse($result['valid']);
        $this->assertArrayHasKey('nickName', $result['errors']);
    }

    /**
     * Test de validation avec règle inconnue
     */
    public function testValidateFormUnknownRule(): void
    {
        $data = [
            'test' => 'value'
        ];

        $rules = [
            'test' => [['unknown_rule']],
        ];

        $result = Validator::validateForm($data, $rules);

        $this->assertFalse($result['valid']);
        $this->assertArrayHasKey('test', $result['errors']);
        $this->assertStringContainsString('inconnue', $result['errors']['test'][0]);
    }
}
