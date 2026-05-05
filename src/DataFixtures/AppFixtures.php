<?php

namespace App\DataFixtures;

use App\Entity\Serie;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{


    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; ++$i) {
            $user = new User();
            $user->setRoles(['ROLE_USER'])
                ->setEmail($faker->email())
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setPassword($this->passwordHasher->hashPassword($user, 'aze'));
            ;
            $manager->persist($user);
        }
        $manager->flush();
    }


}
