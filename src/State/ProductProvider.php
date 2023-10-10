<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\ProductRepository;

class ProductProvider implements ProviderInterface
{
    public function __construct(
        private ProductRepository $repo
    )
    {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        /** @var ?Product $product */
        return $this->repo->getHighestPriceProduct();
    }
    
}
