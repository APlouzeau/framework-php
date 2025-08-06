<?php

namespace EyoPHP\Framework\Tests\Unit;

use PHPUnit\Framework\TestCase;
use EyoPHP\Framework\Entity\User;

/**
 * Test class for the new User Entity (PSR-4 version)
 */
class UserEntityTest extends TestCase
{
    private const TEST_EMAIL = 'test@example.com';
    private const TEST_DATETIME = '2025-01-01 10:00:00';

    private User $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    /**
     * Test user entity creation with all properties
     */
    public function testCreatesUserWithAllProperties()
    {
        $userData = [
            'id_user' => 1,
            'nickname' => 'testuser',
            'mail' => self::TEST_EMAIL,
            'created_at' => self::TEST_DATETIME,
            'id_role' => 2
        ];

        $user = new User($userData);

        $this->assertEquals(1, $user->getId_user());
        $this->assertEquals('testuser', $user->getNickname());
        $this->assertEquals(self::TEST_EMAIL, $user->getMail());
        $this->assertEquals(self::TEST_DATETIME, $user->getCreated_at());
        $this->assertEquals(2, $user->getId_role());
    }

    /**
     * Test namespace and alias compatibility
     */
    public function testNamespaceAliasCompatibility()
    {
        // Test que l'alias fonctionne
        $legacyUserClass = 'EntitieUser';
        $this->assertTrue(class_exists($legacyUserClass), 'EntitieUser alias should exist');

        $legacyUser = new $legacyUserClass();
        $newUser = new User();

        // Les deux classes doivent avoir les mêmes méthodes
        $this->assertTrue(method_exists($legacyUser, 'getNickname'));
        $this->assertTrue(method_exists($newUser, 'getNickname'));

        $this->assertTrue(method_exists($legacyUser, 'hasRoleId'));
        $this->assertTrue(method_exists($newUser, 'hasRoleId'));

        // Test que les deux objets sont de la même classe réelle
        $this->assertInstanceOf(User::class, $legacyUser);
    }

    /**
     * Test utility methods
     */
    public function testUtilityMethods()
    {
        $this->user->setId_role(3); // admin
        $this->assertTrue($this->user->isAdmin());
        $this->assertFalse($this->user->isModerator());

        $this->user->setId_role(2); // moderator
        $this->assertFalse($this->user->isAdmin());
        $this->assertTrue($this->user->isModerator());
    }

    /**
     * Test toArray method
     */
    public function testToArrayMethod()
    {
        $this->user->setId_user(1);
        $this->user->setNickname('testuser');
        $this->user->setMail(self::TEST_EMAIL);
        $this->user->setPassword('secret');

        $array = $this->user->toArray();

        $this->assertArrayHasKey('id_user', $array);
        $this->assertArrayHasKey('nickname', $array);
        $this->assertArrayHasKey('mail', $array);
        $this->assertArrayNotHasKey('password', $array); // Par défaut, pas de password

        $arrayWithPassword = $this->user->toArray(true);
        $this->assertArrayHasKey('password', $arrayWithPassword);
    }
}
