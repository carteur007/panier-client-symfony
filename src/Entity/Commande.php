<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('slug')]
class Commande
{
    use EntityTrait;
    
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateCmd = null;

    #[ORM\Column(nullable: true)]
    private ?bool $status = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'commandes')]
    private Collection $produits;

    #[ORM\Column]
    private ?int $quantities = null;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getDateCmd(): ?\DateTimeImmutable
    {
        return $this->dateCmd;
    }

    public function setDateCmd(?\DateTimeImmutable $dateCmd): static
    {
        $this->dateCmd = $dateCmd;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Product $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
        }

        return $this;
    }

    public function removeProduit(Product $produit): static
    {
        $this->produits->removeElement($produit);

        return $this;
    }

    public function getQuantities(): ?int
    {
        return $this->quantities;
    }

    public function setQuantities(int $quantities): static
    {
        $this->quantities = $quantities;

        return $this;
    }
}
