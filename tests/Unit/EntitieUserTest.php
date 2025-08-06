<?php

namespace EyoPHP\Framework\Tests\Unit;

use PHPUnit\Framework\TestCase;
use EyoPHP\Framework\Entity\User;

/**
 * Test class for EntitieUser (legacy alias)
 * Demonstrates testing data entities and object behavior using the legacy alias
 */
class EntitieUserTest extends TestCase
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

        // Test direct avec la classe moderne
        $user = new User($userData);

        $this->assertEquals(1, $user->getId_user());
        $this->assertEquals('testuser', $user->getNickname());
        $this->assertEquals(self::TEST_EMAIL, $user->getMail());
        $this->assertEquals(self::TEST_DATETIME, $user->getCreated_at());
        $this->assertEquals(2, $user->getId_role());

        // Vérifier que c'est une instance User
        $this->assertInstanceOf(User::class, $user);
    }
    /**
     * Test hasRoleId method functionality
     */
    public function testChecksUserRoleIdCorrectly()
    {
        $this->user->setId_role(3); // admin

        $this->assertTrue($this->user->hasRoleId(3));
        $this->assertFalse($this->user->hasRoleId(1));
        $this->assertFalse($this->user->hasRoleId(2));
    }

    /**
     * Test hasRoleId returns false for default role
     */
    public function testReturnsFalseForDefaultRole()
    {
        // Par défaut, id_role sera 0 ou non défini
        $this->assertFalse($this->user->hasRoleId(3));
        $this->assertFalse($this->user->hasRoleId(1));
    }

    /**
     * Test isAdmin convenience method
     */
    public function testIdentifiesAdminUsers()
    {
        $this->user->setId_role(3); // admin
        $this->assertTrue($this->user->isAdmin());

        $this->user->setId_role(1); // user
        $this->assertFalse($this->user->isAdmin());
    }

    /**
     * Test toArray method returns all properties
     */
    public function testConvertsToArray()
    {
        $this->user->setId_user(1);
        $this->user->setNickname('testuser');
        $this->user->setMail(self::TEST_EMAIL);
        $this->user->setCreated_at(self::TEST_DATETIME);
        $this->user->setUpdated_at(self::TEST_DATETIME);
        $this->user->setId_role(2);

        $array = $this->user->toArray();

        $expected = [
            'id_user' => 1,
            'nickname' => 'testuser',
            'mail' => self::TEST_EMAIL,
            'created_at' => self::TEST_DATETIME,
            'updated_at' => self::TEST_DATETIME,
            'id_role' => 2
        ];

        $this->assertEquals($expected, $array);
    }
}
