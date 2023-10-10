<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Product;

class ProductCreateProcessor implements ProcessorInterface
{
    //private ProcessorInterface $decorated;

    // bin/console make:state-processor ArticleSetDiscountsProcessor

    public function __construct(private ProcessorInterface $decorated)
    {
        //$this->decorated = $decorated;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Product
    {
        if (!$data instanceof Product) {
            throw new \InvalidArgumentException('Type de produit invalide');
        }
        $data->setCurrency(Product::DEFAULT_CURRENCY);
        return $this->decorated->process($data,$operation,$uriVariables,$context);
    }
}
