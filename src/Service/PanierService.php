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
     * $produit ajouter au panier, 
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
        foreach ($panier as $slug => $quantite) {
            $product = $this->prodservice->oneBy("slug",$slug);
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
     * @param $slug identifiant du produit a acheter
     * @param $session SessionInterface la variable session de symfony
     */
    public function setPanier(SessionInterface $session, string $slug): void
    {
        $panier = $session->get("panier",[]);
        if (!empty($panier[$slug])) {
            $panier[$slug]++;
        }else {
            $panier[$slug] = 1;
        }
        $session->set("panier",$panier);
    }
    /**
     * Fonction permettant diminuer la quantite de packcv dans le panier
     * @param $slug identifiant du paroduit
     * @param $session SessionInterface la variable session de symfony
     */
    public function removePanier(SessionInterface $session, string $slug): void
    {
        $panier = $session->get("panier",[]);
        if (!empty($panier[$slug])) {
            if ($panier[$slug] > 1) {
                $panier[$slug]--;
            }else {
                unset($panier[$slug]);
            }
        }
        $session->set("panier",$panier);
    }
    /**
     * Fonction permettant supprimer un element complet dans le panier
     * @param $slug identifiant du produit 
     * @param $session SessionInterface la variable session de symfony
     */
    public function deletePanier(SessionInterface $session, string $slug)
    {
        $message = '';
        $panier = $session->get("panier",[]);
        if (!empty($panier[$slug])) {
            unset($panier[$slug]);
            $message = "Produit retirer avec success du panier";
        }
        else {
            $message = "Produit inexistant dans le panier";
        }
        $session->set("panier",$panier);
        return $message;
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