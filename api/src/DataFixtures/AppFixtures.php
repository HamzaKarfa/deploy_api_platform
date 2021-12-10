<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
            $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setEmail('hamza.karfa@gmail.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, '123456'));
        $user->setUsername('Hamza');
        $user->setRoles(['ROLE_ADMIN']);
        $user2 = new User();
        $user2->setEmail('hamza@gmail.com');
        $user2->setPassword($this->passwordHasher->hashPassword($user2, '123456'));
        $user2->setUsername('HamzaUser');
        $manager->persist($user2);
        $manager->persist($user);
        $manager->flush();
    }
}

