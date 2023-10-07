<?php
namespace App\Controller;

use App\Entity\Product;
use App\Service\PanierService as PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/panier', name: 'app_panier_')]
class PanierSessionController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function panier(PanierService $panierservice, SessionInterface $session): Response
    {
        return $this->render('panier_session/index.html.twig',[
            'session' => $session
        ]);
    }
    #[Route('/get', name: 'get_all')]
    public function getPanier(PanierService $panierservice, SessionInterface $session): Response
    {
        return new JsonResponse(
            $panierservice->getPanier($session),
            200,
            ["Content-Type" => "application/json"]
        );
    }
    /**
     * Fonction permettant de recuperer le panier utilisateur
     * @param $session SessionInterface la variable session de symfony
     * @param $panierservice PanierService le service de gestion du panier
     * 
     */
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
    /**
     * Fonction permettant d'initialiser le panier utilisateur
     * @param $product Product à ajouter au panier
     * @param $session SessionInterface la variable session de symfony
     * @param $panierservice PanierService le service de gestion du panier
     */
    #[Route('/add/{slug}', name: 'add', methods: ['GET', 'POST'])]
    public function add(PanierService $panierservice, SessionInterface $session, Product $product)
    {
        $panierservice->setPanier($session,$product->getSlug());
        return $this->redirectToRoute("app_index");
    }
    /**
     * Fonction permettant diminuer la quantite de packcv dans le panier
     * @param $product Product dont la quqntité sera diminuer
     * @param $session SessionInterface la variable session de symfony
     * @param $panierservice PanierService le service de gestion du panier
     */
    #[Route('/remove/{slug}', name: 'remove', methods: ['GET', 'POST'])]
    public function remove(PanierService $panierservice, SessionInterface $session, Product $product)
    {
        $panierservice->removePanier($session,$product->getId());
    }
    /**
     * Fonction permettant supprimer un element complet dans le panier
     * @param $product à supprimer du panier
     * @param $session SessionInterface la variable session de symfony
     * @param $panierservice PanierService le service de gestion du panier
     */
    #[Route('/delete/{slug}', name: 'delete', methods: ['GET', 'POST'])]
    public function delete(PanierService $panierservice, SessionInterface $session, $slug)
    {
        $sms = $panierservice->deletePanier($session,$slug);
        return new JsonResponse(
            ["message" => $sms],
            200,
            ["Content-Type" => "application/json"]
        );
    }
    /**
     * Fonction permettant supprimer completement le panier
     * @param $session SessionInterface la variable session de symfony
     * @param $panierservice PanierService le service de gestion du panier
     */
    #[Route('/deleteAll', name: 'deleteAll', methods: ['GET', 'POST'])]
    public function deleteAll(PanierService $panierservice, SessionInterface $session)
    {
        $panierservice->deleteAllPanier($session);
    }
}
