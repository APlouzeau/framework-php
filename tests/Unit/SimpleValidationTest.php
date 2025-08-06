<?php

namespace EyoPHP\Framework\Tests\Unit;

use PHPUnit\Framework\TestCase;
use EyoPHP\Framework\Validation\Validator;

/**
 * Tests de validation - EyoPHP Framework
 * 
 * Tests des méthodes de validation modernisées (validate*) 
 * du Validator avec messages français
 * 
 * @package EyoPHP\Framework\Tests\Unit
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0 (mis à jour avec nouvelles méthodes)
 */
class SimpleValidationTest extends TestCase
{
    public function testEmailValidationWorks()
    {
        $result = Validator::validateEmail('test@example.com');
        $this->assertEquals(1, $result['code']);
    }

    public function testEmailValidationFailsForInvalidEmail()
    {
        $result = Validator::validateEmail('invalid-email');
        $this->assertEquals(0, $result['code']);
    }

    public function testNicknameValidationWorks()
    {
        $result = Validator::validateNickname('testuser');
        $this->assertEquals(1, $result['code']);
    }

    public function testNicknameValidationFailsForShortName()
    {
        $result = Validator::validateNickname('a');
        $this->assertEquals(0, $result['code']);
    }

    public function testPasswordValidationWorks()
    {
        $result = Validator::validatePasswordFormat('SecurePass123!');
        $this->assertEquals(1, $result['code']);
    }

    public function testPasswordValidationFailsForWeakPassword()
    {
        $result = Validator::validatePasswordFormat('weak');
        $this->assertEquals(0, $result['code']);
    }

    public function testValidateNotEmptyWorks()
    {
        $result = Validator::validateNotEmpty('test', 'nom');
        $this->assertEquals(1, $result['code']);
    }

    public function testValidateNotEmptyFailsForEmptyString()
    {
        $result = Validator::validateNotEmpty('', 'nom');
        $this->assertEquals(0, $result['code']);
    }

    public function testValidateLengthWorks()
    {
        $result = Validator::validateLength('testuser', 3, 50, 'pseudo');
        $this->assertEquals(1, $result['code']);
    }

    public function testValidateLengthFailsForTooShort()
    {
        $result = Validator::validateLength('ab', 3, 50, 'pseudo');
        $this->assertEquals(0, $result['code']);
    }

    public function testValidateMatchWorks()
    {
        $result = Validator::validateMatch('password123', 'password123', 'mot de passe');
        $this->assertEquals(1, $result['code']);
    }

    public function testValidateMatchFailsForDifferentValues()
    {
        $result = Validator::validateMatch('password123', 'different', 'mot de passe');
        $this->assertEquals(0, $result['code']);
    }
}
