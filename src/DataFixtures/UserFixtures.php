<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class UserFixtures extends Fixture
{

    private $passwordHasherFactory;

    public function __construct(PasswordHasherFactoryInterface $encoderFactory)
    {
        $this->passwordHasherFactory = $encoderFactory;
    }

    public static function getReferenceKey($i)
    {
        return sprintf('user_%d', $i);
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('username');
        $user->setPassword($this->passwordHasherFactory->getPasswordHasher($user)->hash('password'));
        $user->setEmail('email@email.com');
        $manager->persist($user);
        $this->addReference(self::getReferenceKey(0), $user);

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword($this->passwordHasherFactory->getPasswordHasher($admin)->hash('password'));
        $admin->setEmail('admin@email.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);
        $this->addReference(self::getReferenceKey(1), $admin);

        $manager->flush();
    }
}
