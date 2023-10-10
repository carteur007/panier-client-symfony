<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\ORM\Mapping\PrePersist;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('slug')]
#[
    ApiResource(
        operations: [
            new Post(),
            new Put(),
            new Get(),
            new GetCollection(),
            new Delete(),
        ],
    order: ['dateCmd' => 'ASC'], 
    paginationEnabled: false,
    )
]
class Commande
{
    use EntityTrait;
    
    #[Assert\Type("\DateTimeInterface")]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateCmd = null;

    #[ORM\Column(nullable: true)]
    private ?bool $status = false;

    #[Assert\NotBlank()]
    #[ORM\ManyToOne(inversedBy: 'commandes',cascade: ['persist'])]
    private ?User $user = null;

    #[Assert\NotBlank()]
    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'commandes')]
    private Collection $produits;

    #[Assert\NotBlank()]
    #[ORM\Column]
    private ?int $quantities = null;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }
    public function getIdentifier(): string
    {
        list($day, $month, $year, $hour, $min, $sec) = explode("/", $this->getCreatedAt()->format('d/m/Y/h/i/s'));
        $date = $day.'-'.$month.'-'.$year.'-'.$hour.'-'.$min.'-'.$sec;
        return 'CMD_'.$this->getQuantities().($this->getUser())->getUserIdentifier().'_'.$date;
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

    #[PrePersist]
    public function setStatusCreated()
    {
        $this->status = false;
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
