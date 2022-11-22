<?php

namespace Tests\AppBundle\Entity;

use App\Entity\User;
use App\Entity\Task;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testConstruct()
    {
        $user = new User();
        $this->assertInstanceOf(User::class, $user);
    }

    public function testId()
    {
        $user = new User();
        $this->assertNull($user->getId());
    }


    public function testUsername()
    {
        $user = new User();
        $user->setUsername('username');
        $this->assertEquals('username', $user->getUsername());
    }


    public function testPassword()
    {
        $user = new User();
        $user->setPassword('password');
        $this->assertEquals('password', $user->getPassword());
    }

    public function testEmail()
    {
        $user = new User();
        $user->setEmail('email');
        $this->assertEquals('email', $user->getEmail());
    }

    public function testSalt()
    {
        $user = new User();
        $this->assertNull($user->getSalt());
    }

    public function testEveryUsersHaveUserRole()
    {
        $user = new User();
        $user2 = new User();
        $user2->setRoles(['ROLE_ADMIN']);
        
        $this->assertTrue(in_array('ROLE_USER', $user->getRoles()));
        $this->assertTrue(in_array('ROLE_USER', $user2->getRoles()));
    }

    public function testUserCanHaveAdminRole()
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);
        $this->assertTrue(in_array('ROLE_ADMIN', $user->getRoles()));
    }

    public function testUserCanHaveTasks()
    {
        $user = new User();
        $user->addTask(new Task());
        $this->assertCount(1, $user->getTask());
    }

    public function testUserCanHaveManyTasks()
    {
        $user = new User();
        $user->addTask(new Task());
        $user->addTask(new Task());
        $this->assertCount(2, $user->getTask());
    }

    public function testUserCanRemoveTasks()
    {
        $user = new User();
        $task = new Task();
        $user->addTask($task);
        $user->removeTask($task);
        $this->assertCount(0, $user->getTask());
    }

    public function testUserIdentifier()
    {
        $user = new User();
        $user->setUsername('username');
        $this->assertEquals('username', $user->getUserIdentifier());
    }

    public function testEraseCredentials()
    {
        $user = new User();
        $this->assertNull($user->eraseCredentials());
    }
}