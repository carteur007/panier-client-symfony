<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Category;
use App\Entity\Product;
use App\Service\ProductService;
use Doctrine\Common\Collections\ArrayCollection;

class ProductSetDiscountsProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ProductService $productService,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ArrayCollection
    {
        if (!$data instanceof Product) {
            throw new \Exception('Invalid object type');
        }
        /** @var ?Category $category */
        $category = $data->getCategory();

        $produits = $this->productService->updateProduitByDiscountPercentageByCategory($category, $data->getDiscountPercentage());

        return new ArrayCollection($produits);
    }
}
