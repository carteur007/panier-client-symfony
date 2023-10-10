<?php
namespace App\Entity;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ProductRepository;
use App\State\ProductCreateProcessor;
use App\State\ProductProvider;
use App\State\ProductResetAllDiscountsProvider;
use App\State\ProductSetDiscountsProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[
    ORM\Entity(repositoryClass: ProductRepository::class),
    ORM\Table(name: 'product'),
    UniqueEntity('slug'),
]
#[
    ApiResource(
        operations: [
            new Post(),
            new Put(),
            new Get(),
            new GetCollection(),
            new Delete(),
        ],
    order: ['quantity' => 'DESC', 'price' => 'ASC'], 
    paginationEnabled: false,
    )
]
#[ORM\HasLifecycleCallbacks]
class Product
{
    use EntityTrait;
    use DiscountTraits;

    public const DISCOUNT_DEFAULT_VALUE = null;
    public const DEFAULT_CURRENCY = '$';

    #[
        ORM\Column(name: 'name', type: Types::STRING, length: 255, nullable: false),
        Assert\NotBlank(message: 'Le nom ne peut etre vide'),
        Assert\Type(Types::STRING)
    ]
    private ?string $name = null;

    #[
        ORM\Column(name: 'description', type: Types::STRING, length: 255, nullable: false),
        Assert\NotBlank(message: 'la description ne peut etre vide'),
        Assert\Type(Types::STRING),
        
    ]
    private ?string $description = null;

    #[  
        ORM\Column(name: 'image_name', type: Types::STRING,length: 255, nullable: true),
        Assert\IsNull(),
        Assert\Type(Types::STRING)
    ]
    private ?string $imageName = null;

    #[
        ORM\Column(name: 'quantity', type: Types::FLOAT, nullable: false),
        Assert\NotNull(
            message: 'La quantite ne peut etre null',
        ),
        Assert\NotBlank(message: 'La quantite ne peut etre null'),
        Assert\Type(Types::INTEGER),
        
    ]
    private ?int $quantity = null;

    #[
        ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'produits')
    ]
    private Collection $commandes;

    #[
        ORM\ManyToOne(targetEntity: Category::class, cascade: ['persist'], inversedBy: 'produits'),
        ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id', nullable: false),
    ]
    private ?Category $category = null;

    public function __construct()
    {
        $this->currency = self::DEFAULT_CURRENCY;
        $this->commandes = new ArrayCollection();
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
    public function getIdentifier(): string
    {
        return (string) $this->getName();
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->addProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeProduit($this);
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
