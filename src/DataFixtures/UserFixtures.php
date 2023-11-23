<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $hasher
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
       $faker = Factory::create('fr_FR');
       
       $user = new User();
       $user->setEmail("louis@pinoit.com")
                 ->setPassword(
                        $this->hasher->hashPassword($user, "password")
                 )
                 ->setFirstName("Louis");

        $manager->persist($user);
                 

        for ($i=0; $i < 9; $i++) { 
            $user = new User();
            $user->setEmail($faker->email())
                 ->setPassword(
                        $this->hasher->hashPassword($user, "password")
                 )
                 ->setFirstName($faker->firstName())
                 ->setLastName($faker->lastName());
                 

            $manager->persist($user);
        }
       
        $manager->flush();
    }
}
