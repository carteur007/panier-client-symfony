<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait DiscountTraits
{
    #[
        ORM\Column(name: 'price', type: Types::FLOAT, nullable: false),
        Assert\NotNull(
            message: 'Le prix ne peut etre null',
            groups: ['product:create', 'product:update', 'product:get']
        ),
        Assert\Range(
            notInRangeMessage: 'Le prix doit etre compris entre {{ min }} et {{ max }}',
            min: 1,
            max: 10000000
        ),
        Assert\NotBlank(message: 'Le prix ne peut etre null', groups: ['price:create']),
        Assert\Type(Types::FLOAT, groups: ['product:create']),
        Groups(['product:get', 'product:update', 'product:create']),
    ]
    private ?float $price;

    #[
        ORM\Column(name: 'discount_percentage', type: Types::FLOAT, nullable: true),
        Assert\NotBlank(message: 'Le pourcentage de reduction ne peut etre null', groups: ['price:create']),
        Assert\Range(
            notInRangeMessage: 'La reduction doit etre compris entre {{ min }} et {{ max }} %',
            min: 1,
            max: 50
        ),
        Groups(['product:get', 'product:update', 'product:discount:put',]),
    ]
    private ?int $discountPercentage = null;

    private ?int $discountPrice = null;

    #[
        ORM\Column(name: 'currency', type: Types::STRING, length: 10),
        Assert\NotNull(
            message: 'La monaie ne peut etre null',
            groups: ['product:create', 'product:update', 'product:get']
        ),
        Groups(['product:get']),
    ]
    private ?string $currency;

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getDiscountPercentage(): ?float
    {
        return $this->discountPercentage;
    }

    public function setDiscountPercentage(?float $discountPercentage): self
    {
        $this->discountPercentage = $discountPercentage;

        return $this;
    }

    public function getDiscountPrice(): ?float
    {
        $this->discountPrice = $this->discountPercentage !== null ? (1 - ($this->discountPercentage / 100)) * $this->price : null;
        return $this->discountPrice;
    }

    public function setDiscountPrice(?float $discountPrice): void
    {
        $this->discountPrice = $discountPrice;
    }
    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }
}
