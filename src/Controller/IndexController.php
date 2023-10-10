<?php

namespace App\Controller;

use App\Service\GestionProducts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(GestionProducts $gestion,SessionInterface $session): Response 
    {
        $products = $gestion->alls();
        return $this->render('index/index.html.twig', [
            'products' => $products,
            'session' => $session
        ]);
    }
}
