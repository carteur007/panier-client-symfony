<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $images = [];
        for ($i = 1; $i <= 12; $i++) {
            $product = new Product();
            $cat = new Category();
            $product
                ->setName('Product ' . uniqid())
                ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua')
                ->setRpp(mt_rand(1,20))
                ->setImageName("bureauetudeentrep-65186e94f0c25.png")
                ->setQuantity(mt_rand(10,15))
                ->setPrice(mt_rand(10, 600))
                ->setSlug(uniqid("slug",true))
                ->setCategory(
                    $cat
                        ->setName('Category-Prod'. uniqid())
                        ->setIntitule('Lorem ipsum dolor sit amet, consectetur')
                        ->setSlug(uniqid("slug",true))
                    );
            $manager->persist($cat);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
