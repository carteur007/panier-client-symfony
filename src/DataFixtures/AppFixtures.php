<?php
namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Commande;
use App\Entity\Product;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher){}

    public function load(ObjectManager $manager): void
    {
        //Users
        $tabusers = [];
        $tabcat = [];
        $tabprods = [];
        $commandes = [];
        for ($i = 0; $i <= 5; $i++) {
            $user = new User();
            $user
                ->setUserName('User'. uniqid())
                ->setEmail('user'.uniqid().'@'.'com')
                ->setRoles(['ROLE_USER'])
                ->setAdresse('Adresse'.uniqid())
                ->setPhone(mt_rand(1,12))
            ;
            $password = $this->hasher->hashPassword($user, uniqid('$'));
            $user->setPassword($password);
            $manager->persist($user); 
            $tabusers[$i] = $user;
        }
        //Categorie
        for ($i = 0; $i <= 5; $i++) {
            $category = new Category();
            $category->setName('Category'.uniqid())
                ->setIntitule("Lorem ipsum dolor sit amet, consectetur")
            ;
            $manager->persist($category); 
            $tabcat[$i] = $category;
        }
        //Produits
        for ($i = 1; $i <= 20; $i++) {
            $product = new Product();
            $product->setName('Product' . uniqid())
                ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua')
                ->setDiscountPercentage(mt_rand(1,20))
                ->setImageName("bureauetudeentrep-65186e94f0c25.png")
                ->setQuantity(mt_rand(10,15))
                ->setPrice(mt_rand(10, 600))
            ;
            $product->setCategory($tabcat[mt_rand(1,count($tabcat)-1)]);
            $manager->persist($product);
            $tabprods[$i] = $product;
        }
        //Commandes
        for ($i = 0; $i <= 10; $i++) {
            $cmd = new Commande();
            $user = new User();
            $user
                ->setUserName('User' . uniqid())
                ->setEmail('user'.uniqid().'@'.'com')
                ->setRoles(['ROLE_USER'])
                ->setAdresse('Adresse' . uniqid())
                ->setPhone(mt_rand(1,12))
                //->setSlug(uniqid("slug",true));
            ;
            $password = $this->hasher->hashPassword($user, uniqid('$'));
            $user->setPassword($password);
            $manager->persist($user); 
            array_push($tabusers,$user);
            $cmd
                ->setDateCmd(new DateTimeImmutable('now'))
                ->setStatus((($i/2) !== 0)?1:0)
                ->setQuantities(mt_rand(1,6))
                ->setUser($user)
            ;
            for ($j = 1; $j <= mt_rand(1,count($tabprods)-1); $j++) {
                $cmd->addProduit($tabprods[$j]);
            }   
            $manager->persist($cmd); 
            $commandes[$i] = $cmd;
        }
        //Users Commandes
        for ($i = 0; $i <= 10; $i++) 
        {
            $cmd = new Commande();
            $cmd
                ->setDateCmd((new DateTimeImmutable('now')))
                ->setStatus((($i/2) === 0)?1:0)
                ->setQuantities(mt_rand(1,100))
                ->setUser($tabusers[mt_rand(1,count($tabusers)-1)])
            ;
            for ($k = 1; $k <= mt_rand(1,count($tabprods)-1); $k++) {
                $product = new Product();
                $product->setName('Product' . uniqid())
                    ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua')
                    ->setDiscountPercentage(mt_rand(1,20))
                    ->setImageName("bureauetudeentrep-65186e94f0c25.png")
                    ->setQuantity(mt_rand(10,15))
                    ->setPrice(mt_rand(10, 600))
                ;
                $product->setCategory($tabcat[mt_rand(1,count($tabcat)-1)]);
                $manager->persist($product);
                $cmd->addProduit($product);
                array_push($tabprods,$product);
            }
            $manager->persist($cmd); 
            array_push($commandes, $cmd);   
        }
        $manager->flush();
    }
}
