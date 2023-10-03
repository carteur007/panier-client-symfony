<?php
namespace App\Service;

use App\Service\GestionProducts;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService  
{
    private $prodservice = null;

    public function __construct(
        GestionProducts $prodservice)
    {
        $this->prodservice = $prodservice;
    }

    /**
     * Fonction permettant de recuperer le panier utilisateur
     * @return $panierData[] un tbleau qui contient
     * $datapanier qui contient a son tour le tableau de
     * $pack de cv ajouter au panier, 
     * $total ajouter en fonction de la $quantite 
     * $totals le montant total de la commande
     * $nbres le nombre de produit dans le panier
     * $products tous les produits disponible en base de donnee
     * @param $session SessionInterface la variable session de symfony
     * 
     */
    public function getPanier(SessionInterface $session) 
    {
        $panierData = [];
        $panier = $session->get("panier",[]);
        $productpanier = [];
        $total = 0;
        $nbres = 0;
        foreach ($panier as $id => $quantite) {
            $product = $this->prodservice->one($id);
            $nbres++;
            $productpanier[] = [
                "product" => $product,
                "quantite" => $quantite,
            ];
            $total += $product->getPrice() * $quantite;
        }
        
        $panierData["nbres"] = $nbres;
        $panierData["total"] = $total;
        $panierData["productpanier"] = $productpanier;

        return $panierData;
    }
    /**
     * Fonction permettant d'initialiser le panier utilisateur
     * @param $id identifiant du produit a acheter
     * @param $session SessionInterface la variable session de symfony
     */
    public function setPanier(SessionInterface $session,int $id): void
    {
        $panier = $session->get("panier",[]);
        if (!empty($panier[$id])) {
            $panier[$id]++;
        }else {
            $panier[$id] = 1;
        }
        $session->set("panier",$panier);
    }
    /**
     * Fonction permettant diminuer la quantite de packcv dans le panier
     * @param $id identifiant du pack des cv a acheter
     * @param $session SessionInterface la variable session de symfony
     */
    public function removePanier(SessionInterface $session,int $id): void
    {
        $panier = $session->get("panier",[]);
        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            }else {
                unset($panier[$id]);
            }
        }
        $session->set("panier",$panier);
    }
    /**
     * Fonction permettant supprimer un element complet dans le panier
     * @param $id identifiant du pack des cv a acheter
     * @param $session SessionInterface la variable session de symfony
     */
    public function deletePanier(SessionInterface $session,int $id): void
    {
        $panier = $session->get("panier",[]);
        if (!empty($panier[$id])) {
                unset($panier[$id]);
        }
        $session->set("panier",$panier);
    }
    /**
     * Fonction permettant supprimer completement le panier
     * @param $session SessionInterface la variable session de symfony
     */
    public function deleteAllPanier(SessionInterface $session): void
    {
        $session->remove("panier");
    }
    
}