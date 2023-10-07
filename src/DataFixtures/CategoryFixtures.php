<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 3; $i++) {
            $category = new Category();
            $category
                ->setName('Category ' . uniqid())
                ->setIntitule("Lorem ipsum dolor sit amet, consectetur")
                ->setSlug(uniqid("slug",true));

            $manager->persist($category); 
        }
        $manager->flush();
    }
}
