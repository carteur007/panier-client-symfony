<?php
namespace App\Controller;

use App\Entity\Product;
use App\Service\PanierService as PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier', name: 'app_panier_',methods: ['GET'])]
class PanierSessionController extends AbstractController
{
    #[Route('/session', name: 'session')]
    public function index(PanierService $panierservice, SessionInterface $session): Response
    {
        $panier = $panierservice->getPanier($session);
        return new JsonResponse(
            $panier,
            200,
            ["Content-Type" => "application/json"]
        );
    }
    #[Route('/add/{id}', name: 'add', methods: ['GET', 'POST'])]
    public function add(PanierService $panierservice, SessionInterface $session, Product $product)
    {
        $panierservice->setPanier($session,$product->getId());
    }
    #[Route('/remove/{id}', name: 'remove', methods: ['GET', 'POST'])]
    public function remove(PanierService $panierservice, SessionInterface $session, Product $product)
    {
        $panierservice->removePanier($session,$product->getId());
    }
    #[Route('/delete/{id}', name: 'delete', methods: ['GET', 'POST'])]
    public function delete(PanierService $panierservice, SessionInterface $session, Product $product)
    {
        $panierservice->deletePanier($session,$product->getId());
    }
    #[Route('/deleteAll/{id}', name: 'deleteAll', methods: ['GET', 'POST'])]
    public function deleteAll(PanierService $panierservice, SessionInterface $session)
    {
        $panierservice->deleteAllPanier($session);
    }
}
