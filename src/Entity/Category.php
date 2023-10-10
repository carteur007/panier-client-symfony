<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
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
use Doctrine\DBAL\Types\Types;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CategoryRepository::class)]
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
    order: ['name' => 'ASC'], 
    paginationEnabled: false,
    )
]class Category
{
    use EntityTrait;
    
    #[
        ORM\Column(name: 'name', type: Types::STRING, length: 255, nullable: false),
        Assert\NotBlank(message: 'Le nom de la categorie ne peut etre vide'),
        Assert\Type(Types::STRING)
    ]
    private ?string $name = null;

    #[
        ORM\Column(name: 'intitule', type: Types::STRING, length: 255, nullable: false),
        Assert\NotBlank(message: 'L\'intitule de la categorie ne peut etre vide'),
        Assert\Type(Types::STRING),
    ]
    private ?string $intitule = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class)]
    private Collection $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }
    public function getIdentifier(): string
    {
        return (string) $this->getName();
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(?string $intitule): static
    {
        $this->intitule = $intitule;

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
            $produit->setCategory($this);
        }

        return $this;
    }

    public function removeProduit(Product $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCategory() === $this) {
                $produit->setCategory(null);
            }
        }

        return $this;
    }
}
