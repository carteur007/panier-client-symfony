<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api', name: 'app_api_')]
class ApiProductController extends AbstractController
{
    public function __construct(
        private ProductService $productService
    ) {}
    public function __invoke(Product $product)
    {
        //$this->productService->handle($product);

    }
    #[Route('/products', name: 'products')]
    public function index(): Response
    {
        return $this->render('class_product_controller_extends_abstract/index.html.twig', [
            'controller_name' => 'ClassProductControllerExtendsAbstractController',
        ]);
    }
}
