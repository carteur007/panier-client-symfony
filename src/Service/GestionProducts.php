<?php
namespace App\Service;

use App\Repository\ProductRepository;
use Psr\Log\LoggerInterface;

class GestionProducts {
    
    private $prodrepo;
    
    public function __construct(
        LoggerInterface $logger,
        ProductRepository $prodrepo
        
    ) {
        $this->prodrepo = $prodrepo;
    }

    /**
     * List all products
     */
    public function alls() {
        return $this->getProdrepo()->findAll();
    }
    /**
     * Get one product
     */
    public function one($id) {
        return $this->getProdrepo()->find($id);;
    }
    /**
     * Get one product by property
     */
    public function oneBy($property,$value) {
        return $this->getProdrepo()->findOneBy([$property => $value]);
    }
    /**
     * ge the repository
     */
    public function getProdrepo() {
        return $this->prodrepo;
    }
}