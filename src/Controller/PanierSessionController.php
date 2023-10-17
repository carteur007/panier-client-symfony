<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/panier', name: 'app_panier_bag_')]
class PanierSessionController extends AbstractController
{
    public function __construct(
        private PanierService $panierService,
        private RequestStack $requestStack
    ) {
    }
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse(
            $this->panierService->getMetadataPanier(),
            200,
            ["Content-type" => "application/json"]
        );
    }
    #[Route('/add/{slug}', name: 'add', methods: ['POST', 'GET'])]
    public function add(Product $product): JsonResponse
    {
        return new JsonResponse(
            ["message" => $this->panierService->ajouter($product->getSlug())],
            201,
            ["Content-type" => "application/json"]
        );
    }
    #[Route('/add/{slug}/{q}', name: 'change_Quantity', methods: ['POST', 'GET'])]
    public function change(Product $product, int $q): JsonResponse
    {
        return new JsonResponse(
            [
                "message" => $this->panierService->ajouter($product->getSlug(), $q),
                "panier" => $this->panierService->getPanier()
            ],
            201,
            ["Content-type" => "application/json"]
        );
    }
    #[Route('/delete/{slug}', name: 'delete', methods: ['DELETE'])]
    public function delete(Product $product)
    {
        return new JsonResponse(
            ["message" => $this->panierService->delete($product->getSlug())],
            200,
            ["Content-Type" => "application/json"]
        );
    }
    #[Route('/clear', name: 'clear', methods: ['DELETE'])]
    public function deletePanier()
    {
        return new JsonResponse(
            ["message" => $this->panierService->deletePanier()],
            200,
            ["Content-Type" => "application/json"]
        );
    }
}
