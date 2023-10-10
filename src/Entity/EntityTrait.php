<?php
namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints as Assert;

trait EntityTrait{


    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column
    ]
    private ?int $id = null;

    #[ORM\Column(name: 'slug', type: Types::STRING,length: 255,unique: true)]
    private ?string $slug = null;

    #[
        Assert\Type("\DateTimeInterface"),
        ORM\Column(nullable: true)
    ]
    private ?\DateTimeImmutable $createdAt = null;

    #[
        Assert\Type("\DateTimeInterface"),
        ORM\Column(nullable: true)
    ]
    private ?\DateTimeImmutable $updatedAt = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function computeSlug(SluggerInterface $slugger)
    {
        if (!$this->slug || '-' === $this->slug) {
            $this->slug = (string) $slugger->slug((string) $this->getIdentifier())->lower();
        }
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    
}