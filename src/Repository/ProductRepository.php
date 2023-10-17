<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator;
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
     * Fonction qui retourne les produits sous forme pagine
     * @return Product[] produits sous forme
     * @param $page le numerode la page
     * @param $max le nombre de produit par page
     */
    public function paginated(int $page, int $max): mixed
    {
        $q = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery();

        $paginator = new Paginator($q);
        $paginator->getQuery()
            ->setFirstResult($max * ($page - 1))
            ->setMaxResults($max);

        return $paginator;
    }
    /** 
     * Fonction qui retourne les produits lier par une relation ManyToOne sous forme pagine
     * @return Product[] produits sous forme
     * @param $page le numerode la page
     * @param $max le nombre de produit par page
     * @param $slug la categorie du produit
     */
    public function manyToOnePaginated(int $page, int $max, string $slug): mixed
    {
        $q = $this->createQueryBuilder('p')
            ->leftJoin('p.category', 'c')
            ->andWhere('c.slug = ?1')
            ->setParameter('1', $slug)
            ->orderBy(['p.createdAt' => Criteria::DESC])
            ->getQuery();

        $paginator = new Paginator($q);
        $paginator->getQuery()
            ->setFirstResult($max * ($page - 1))
            ->setMaxResults($max);

        return $paginator;
    }
    /**
     * @return Product[] Retourne les produits dont le prix est le plus eleve
     */
    public function getHighestPriceProduct(): mixed
    {
        // Example - $qb->expr()->max('u.age')
        $req = $this->createQueryBuilder('p');
        $req->select('p')
            ->from('Product', 'p')
            ->where(
                $req->expr()->max('p.price')
            )
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(1);
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
