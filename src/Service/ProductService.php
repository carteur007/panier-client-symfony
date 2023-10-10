<?php
namespace App\Service;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductService 
{
    private $repo;
    
    public function __construct(ProductRepository $prodrepo) {$this->repo = $prodrepo;}

    /**
     * Recherche un produit par son slug
     */
    public function getProduitBySlug($slug) : mixed 
    {
       return $this->repo->findOneBy(['slug'=> $slug]); 
    }
    /**
     * Recherche un produit par sa categorie
     */
    public function getProduistByCategory(Category $category) : mixed 
    { 
      return $this->repo->findBy(['category'=> $category]);
    }
    /**
     * Creation d'un produit
     */
    public function createProduit(Product $product) : mixed 
    {
        $this->repo->save($product);   
    }
    /**
     * Supprimer un produit par son slug
     */
    public function deleteProduitBySlug(?string $slug) 
    {
        $product = $this->repo->getProduitBySlug($slug);
        $this->repo->remove($product);
    }
    /**
     * Mise a jour d'un produit
     */
    public function updateProduit(Product $product) : mixed {
        $this->repo->save($product);
    }
    /**
     * @return  Product[] Retourne un tableau d'objets produit
     * Mise a jour de tous les produits par categorie
     * Pour changer le pourcentage de reduction
     */
    public function updateProduitByDiscountPercentageByCategory(Category $category, int $discountPercentage) : mixed 
    {
        $produits = $this->getProduistByCategory($category);
        /** @var ?Product $product */
        foreach ($produits as $product) {
            $product->setDiscountPercentage($discountPercentage);
            $this->repo->save($product);
        }
        return $produits;
    }
    /**
     * Mise a jour de tous les produits 
     * Et reinitialisation du pourcentage de reduction
     */
    public function resetAllDiscounts() 
    {
        $produits = $this->repo->findAll();
        /** @var ?Product $product */
        foreach ($produits as $product) {
            $product->setDiscountPercentage(Product::DISCOUNT_DEFAULT_VALUE);
            $this->repo->save($product);
        }
    }
}