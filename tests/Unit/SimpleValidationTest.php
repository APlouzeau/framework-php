<?php

use PHPUnit\Framework\TestCase;

/**
 * Tests de validation - EyoPHP Framework
 * 
 * Tests des méthodes de validation modernisées (validate*) 
 * du ClassValidator avec messages français via ClassTranslation
 * 
 * @package EyoPHP\Tests
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0 (mis à jour avec nouvelles méthodes)
 */
class SimpleValidationTest extends TestCase
{
    public function testEmailValidationWorks()
    {
        $result = ClassValidator::validateEmail('test@example.com');
        $this->assertEquals(1, $result['code']);
    }

    public function testEmailValidationFailsForInvalidEmail()
    {
        $result = ClassValidator::validateEmail('invalid-email');
        $this->assertEquals(0, $result['code']);
    }

    public function testNicknameValidationWorks()
    {
        $result = ClassValidator::validateNickname('testuser');
        $this->assertEquals(1, $result['code']);
    }

    public function testNicknameValidationFailsForShortName()
    {
        $result = ClassValidator::validateNickname('a');
        $this->assertEquals(0, $result['code']);
    }

    public function testPasswordValidationWorks()
    {
        $result = ClassValidator::validatePasswordFormat('SecurePass123!');
        $this->assertEquals(1, $result['code']);
    }

    public function testPasswordValidationFailsForWeakPassword()
    {
        $result = ClassValidator::validatePasswordFormat('weak');
        $this->assertEquals(0, $result['code']);
    }

    public function testValidateNotEmptyWorks()
    {
        $result = ClassValidator::validateNotEmpty('test', 'nom');
        $this->assertEquals(1, $result['code']);
    }

    public function testValidateNotEmptyFailsForEmptyString()
    {
        $result = ClassValidator::validateNotEmpty('', 'nom');
        $this->assertEquals(0, $result['code']);
    }

    public function testValidateLengthWorks()
    {
        $result = ClassValidator::validateLength('testuser', 3, 50, 'pseudo');
        $this->assertEquals(1, $result['code']);
    }

    public function testValidateLengthFailsForTooShort()
    {
        $result = ClassValidator::validateLength('ab', 3, 50, 'pseudo');
        $this->assertEquals(0, $result['code']);
    }

    public function testValidateMatchWorks()
    {
        $result = ClassValidator::validateMatch('password123', 'password123', 'mot de passe');
        $this->assertEquals(1, $result['code']);
    }

    public function testValidateMatchFailsForDifferentValues()
    {
        $result = ClassValidator::validateMatch('password123', 'different', 'mot de passe');
        $this->assertEquals(0, $result['code']);
    }
}
