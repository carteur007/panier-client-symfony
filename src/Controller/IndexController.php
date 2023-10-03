<?php

namespace App\Controller;

use App\Service\GestionProducts as ServiceProducts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(ServiceProducts $gestion): Response 
    {
        $products = $gestion->alls();
        return $this->render('index/index.html.twig', [
            'products' => $products,
        ]);
    }
}
