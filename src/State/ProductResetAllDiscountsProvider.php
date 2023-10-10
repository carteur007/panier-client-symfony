<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Service\ProductService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductResetAllDiscountsProvider implements ProviderInterface
{
    public function __construct(
        private ProductService $productService
    ){}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $this->productService->resetAllDiscounts();
        return new JsonResponse(
            data: ['Reinitialisation du produit effectuer avec succee!'],
            status: Response::HTTP_OK
        );
    }
}
