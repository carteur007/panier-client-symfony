<?php

namespace App\Service;


use App\Service\ProductService;
use Symfony\Component\HttpFoundation\RequestStack;

class PanierService
{
    public function __construct(
        private ProductService $prodservice,
        private RequestStack $requestStack
    ) {
    }
    /**
     * Fonction qui recupere la session utilisateur
     * @return $session SessionInterface Session utilisateur
     */
    public function getSession()
    {
        return $this->requestStack->getSession();
    }
    /**
     * Fonction permettant de construire les metadonnees du panier utilisateur
     * @return $panierData[] un tbleau qui contient
     * $datapanier[] qui contient: [$produit,$quantite] a ajouter au panier, 
     * $total ajouter en fonction de la $quantite 
     * $nbres le nombre de produit dans le panier
     * 
     */
    public function getMetadataPanier(): array
    {
        $panierData = [];
        $session = $this->requestStack->getSession();
        if ($session->isStarted()) {
            $panier = $session->get("panier", []);
            $productpanier = [];
            $total = 0;
            $nbres = 0;
            foreach ($panier as $slug => $quantite) {
                $product = $this->prodservice->getProduitBySlug($slug);
                $nbres++;
                if ($product) :
                    $productpanier[] = [
                        "product" => [
                            "id" => $product->getId(),
                            "slug" =>  $product->getSlug(),
                            "imageName" =>  $product->getImageName(),
                            "price" => $product->getPrice()
                        ],
                        "quantite" => $quantite,
                    ];
                    $total += $product->getPrice() * $quantite;
                else :
                    $this->delete($slug);
                endif;
            }

            $panierData["nbres"] = $nbres;
            $panierData["total"] = $total;
            $panierData["productpanier"] = $productpanier;
        }
        return $panierData;
    }
    /**
     * Fonction permettant de recuperer le panier utilisateur
     * @return $panier[] Panier utilisateur
     * 
     */
    public function getPanier(): array
    {
        return $this->getSession()->get("panier", []);
    }
    /**
     * Fonction permettant de sauvegarder les modifications effectuer sur le panier utilisateur
     * @param $panier[] Panier utilisateur
     */
    public function setPanier(array $panier): void
    {
        $this->getSession()->set("panier", $panier);
    }
    /**
     * Fonction permettant d'initialiser le panier utilisateur
     * @param $slug identifiant du produit a acheter
     * @param $q quantite du produit a acheter
     * @return $sms Message du traitement de l'operation
     */
    public function ajouter(string $slug, int $q = -1): mixed
    {
        $panier = $this->getPanier();
        $sms = "Erreur innatendu";
        if ($q === -1) :
            if (!empty($panier[$slug])) {
                /** @var int */
                $panier[$slug]++;
                $sms = "Quantite augmenter avec success!";
            } else {
                $panier[$slug] = 1;
                $sms = "Produit ajouter avec Success!";
            }
        else :
            if ($q > 0) :
                if (!empty($panier[$slug])) :
                    $panier[$slug] = $q;
                    $sms = "Produit deja dans le panier, quantite augmenter avec success!";
                else :
                    $panier[$slug] = $q;
                    $sms = "Produit ajouter avec Success!";
                endif;
            else :
                //unset($panier[$slug]);
                $sms = "Rien a changer!";
            endif;
        endif;
        $this->setPanier($panier);
        return $sms;
    }
    /**
     * Fonction permettant supprimer un element complet dans le panier
     * @param $slug identifiant du produit 
     * @return $sms Message du traitement de l'operation
     */
    public function delete(string $slug)
    {
        $panier = $this->getPanier();
        if (!empty($panier[$slug]) || \array_key_exists($slug, $panier)) :
            unset($panier[$slug]);
            //$this->getSession()->remove($panier[$slug]);
            $this->setPanier($panier);
            return "Produit retirer avec success du panier!";
        else :
            return "Produit inexistant dans le panier!";
        endif;
    }
    /**
     * Fonction permettant supprimer completement le panier
     * @return $sms Message du traitement de l'operation
     */
    public function deletePanier(): string
    {
        if ($this->getSession()->remove("panier")) :
            return "Panier vider avec success!";
        else :
            return "Un probleme est survenu lors de la surpression du panier!";
        endif;
    }
}
