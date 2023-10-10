<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
    /**
    * @return Product[] Returne les produits dont le prix est le plus eleve
    */
    public function getHighestPriceProduct() : mixed {
        // Example - $qb->expr()->max('u.age')
        $req = $this->createQueryBuilder('p');
        $req->select('p')
            ->from('Product', 'p')
            ->where(
                $req->expr()->max('p.price')
            )
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(1)
        ;
        return $req->getQuery()->getOneOrNullResult();
    }
    /**
     * Enregistre un produit rn base de donnee
     */
    public function save(Product $product)
    { 
        $this->_em->persist($product);
        $this->_em->flush();
    }
//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
