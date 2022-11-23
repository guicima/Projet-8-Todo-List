<?php

namespace Tests\AppBundle\Entity;

use App\Entity\User;
use App\Entity\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{

    public function testConstruct()
    {
        $task = new Task();
        $this->assertInstanceOf(Task::class, $task);
    }

    public function testId()
    {
        $task = new Task();
        $this->assertNull($task->getId());
    }

    public function testTaskHasTitle()
    {
        $task = new Task();
        $task->setTitle('My title');
        $this->assertEquals('My title', $task->getTitle());
    }

    public function testTaskHasContent()
    {
        $task = new Task();
        $task->setContent('My content');
        $this->assertEquals('My content', $task->getContent());
    }

    public function testTaskHasCreatedAt()
    {
        $task = new Task();
        $task->setCreatedAt(new \DateTime());
        $this->assertInstanceOf(\DateTime::class, $task->getCreatedAt());
        $this->assertEquals(date('Y-m-d H:i:s'), $task->getCreatedAt()->format('Y-m-d H:i:s'));
    }

    public function testTaskIsNotDone()
    {
        $task = new Task();
        $this->assertFalse($task->isDone());
    }

    public function testTaskCanBeDone()
    {
        $task = new Task();
        $task->toggle(true);
        $this->assertTrue($task->isDone());
    }

    public function testTaskCanBeUndone()
    {
        $task = new Task();
        $task->toggle(true);
        $task->toggle(false);
        $this->assertFalse($task->isDone());
    }

    public function testTaskHasUser()
    {
        $task = new Task();
        $user = new User();
        $task->setUser($user);
        $this->assertEquals($user, $task->getUser());
    }
}