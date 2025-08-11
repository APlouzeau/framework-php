<?php

namespace EyoPHP\Framework\Tests\Integration;

use EyoPHP\Framework\Core\Database;
use PHPUnit\Framework\TestCase;
use EyoPHP\Framework\Model\UserModel;
use EyoPHP\Framework\Entity\User;
use EyoPHP\Framework\Controller\AuthController;

/**
 * Tests d'intégration pour AuthController
 * 
 * @package EyoPHP\Framework\Tests\Integration
 * @author  Alexandre PLOUZEAU
 * @covers \EyoPHP\Framework\Model\UserModel
 */
class UserModelTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $pdo = Database::getInstance(); // ou ta méthode d’accès PDO
        $pdo->beginTransaction();
    }

    protected function tearDown(): void
    {
        $pdo = Database::getInstance();
        $pdo->rollBack();
        parent::tearDown();
    }

    /**
     * Test d'inscription d'un nouvel utilisateur
     */
    public function testRegisterUser(): void

    {
        $user = new User([
            'nickName' => 'alex_dev',
            'email' => 'alex@eyophp.com',
            'password' => password_hash('SecurePass123!', PASSWORD_BCRYPT),
        ]);

        $userModel = new UserModel();
        $test = $userModel->register($user);
        $this->assertTrue($test, 'L\'utilisateur doit être enregistré avec succès.');
        $found = $userModel->getUserByNickname('alex_dev');
        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals('alex@eyophp.com', $found->getEmail());
    }
}
