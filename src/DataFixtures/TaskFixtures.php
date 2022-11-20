<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\UserFixtures;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = $this->getReference(UserFixtures::getReferenceKey(0));
        $admin = $this->getReference(UserFixtures::getReferenceKey(1));

        for ($i=0; $i < 5; $i++) { 
            $randomNumber= rand(0,1);
            $task = new Task();
            $task->setTitle('Task 1');
            $task->setContent('Content 1');
            $task->setCreatedAt(new \DateTime());
            $task->toggle($randomNumber);
            $task->setUser($i % 2 == 0 ? $user : $admin);
            $manager->persist($task);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
