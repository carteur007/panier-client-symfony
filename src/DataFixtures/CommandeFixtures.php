<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Commande;
use App\Entity\Product;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommandeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i <= 5; $i++) {
            $cmd = new Commande();
            $user = new User();

            for ($j=0; $j <= 2+$i ; $j++) { 
                $cat = new Category();
                $prod = new Product();
                $cmd->addProduit(
                    $prod
                        ->setName('Product-Cmd ' . uniqid())
                        ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua')
                        ->setRpp(mt_rand(1,20))
                        ->setImageName("str-651ae0ee9ac89.jpg")
                        ->setQuantity(mt_rand(10,15))
                        ->setPrice(mt_rand(10, 600))
                        ->setSlug(uniqid("slug",true))
                        ->setCategory(
                            $cat
                                ->setName('Category-Cmd'. uniqid())
                                ->setIntitule('Lorem ipsum dolor sit amet, consectetur')
                                ->setSlug(uniqid("slug",true))
                        )
                );
                $manager->persist($cat); 
                $manager->persist($prod); 

            }
            $user
                ->setUserName('User-Cmd ' . uniqid())
                ->setEmail('userCmd ' . uniqid().'@'.'com')
                ->setRoles(['ROLE_USER'])
                ->setPassword(uniqid('$'))
                ->setAdresse('Adresse-Cmd ' . uniqid())
                ->setPhone(mt_rand(1,12))
                ->setSlug(uniqid("slug",true));
            $manager->persist($user); 
            $cmd
                ->setDateCmd(new DateTimeImmutable())
                ->setStatus((($i/2) === 0)?1:0)
                ->setQuantities(mt_rand(1,6))
                ->setUser($user)
                ->setSlug(uniqid("slug",true));
            $manager->persist($cmd); 
        }
        $manager->flush();
    }
}
