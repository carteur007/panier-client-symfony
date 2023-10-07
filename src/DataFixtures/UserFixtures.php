<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i <= 5; $i++) {
            $user = new User();
            $user
                ->setUserName('User ' . uniqid())
                ->setEmail('user ' . uniqid().'@'.'com')
                ->setRoles(['ROLE_USER'])
                ->setPassword(uniqid('$'))
                ->setAdresse('Adresse ' . uniqid())
                ->setPhone(mt_rand(1,12))
                ->setSlug(uniqid("slug",true));
            $manager->persist($user); 
        }
        $manager->flush();
    }
}