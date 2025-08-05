<?php

use PHPUnit\Framework\TestCase;

/**
 * Simple test to validate our testing setup
 * Tests the existing validator methods
 */
class SimpleValidationTest extends TestCase
{
    public function testEmailValidationWorks()
    {
        $result = ClassValidator::verifyEmail('test@example.com');
        $this->assertEquals(1, $result['code']);
    }

    public function testEmailValidationFailsForInvalidEmail()
    {
        $result = ClassValidator::verifyEmail('invalid-email');
        $this->assertEquals(0, $result['code']);
    }

    public function testNicknameValidationWorks()
    {
        $result = ClassValidator::verifyNickName('testuser');
        $this->assertEquals(1, $result['code']);
    }

    public function testNicknameValidationFailsForShortName()
    {
        $result = ClassValidator::verifyNickName('a');
        $this->assertEquals(0, $result['code']);
    }

    public function testPasswordValidationWorks()
    {
        $result = ClassValidator::verifyPasswordFormat('SecurePass123!');
        $this->assertEquals(1, $result['code']);
    }

    public function testPasswordValidationFailsForWeakPassword()
    {
        $result = ClassValidator::verifyPasswordFormat('weak');
        $this->assertEquals(0, $result['code']);
    }

    public function testMultipleValidationWorks()
    {
        $validations = [
            'email' => ClassValidator::verifyEmail('test@example.com'),
            'nickname' => ClassValidator::verifyNickName('testuser')
        ];

        $result = ClassValidator::validateMultiple($validations);
        $this->assertEquals(1, $result['code']);
        $this->assertEmpty($result['errors']);
    }

    public function testMultipleValidationFailsWithErrors()
    {
        $validations = [
            'email' => ClassValidator::verifyEmail('invalid-email'),
            'nickname' => ClassValidator::verifyNickName('a')
        ];

        $result = ClassValidator::validateMultiple($validations);
        $this->assertEquals(0, $result['code']);
        $this->assertCount(2, $result['errors']);
    }
}
