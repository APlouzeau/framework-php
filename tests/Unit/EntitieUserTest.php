<?php

use PHPUnit\Framework\TestCase;

/**
 * Test class for EntitieUser
 * Demonstrates testing data entities and object behavior
 */
class EntitieUserTest extends TestCase
{
    private EntitieUser $user;

    protected function setUp(): void
    {
        $this->user = new EntitieUser();
    }

    /**
     * Test user entity creation with all properties
     */
    public function testCreatesUserWithAllProperties()
    {
        $userData = [
            'id_user' => 1,
            'nickname' => 'testuser',
            'mail' => 'test@example.com',
            'created_at' => '2025-01-01 10:00:00',
            'id_role' => 2
        ];

        $user = new EntitieUser($userData);

        $this->assertEquals(1, $user->getId_user());
        $this->assertEquals('testuser', $user->getNickname());
        $this->assertEquals('test@example.com', $user->getMail());
        $this->assertEquals('2025-01-01 10:00:00', $user->getCreated_at());
        $this->assertEquals(2, $user->getId_role());
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
        $this->user->setMail('test@example.com');
        $this->user->setCreated_at('2025-01-01 10:00:00');
        $this->user->setUpdated_at('2025-01-01 10:00:00');
        $this->user->setId_role(2);

        $array = $this->user->toArray();

        $expected = [
            'id_user' => 1,
            'nickname' => 'testuser',
            'mail' => 'test@example.com',
            'created_at' => '2025-01-01 10:00:00',
            'updated_at' => '2025-01-01 10:00:00',
            'id_role' => 2
        ];

        $this->assertEquals($expected, $array);
    }
}
