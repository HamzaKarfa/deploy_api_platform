<?php

namespace App\Entity;

use App\Repository\PriceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PriceRepository::class)
 */
class Price
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    #[Groups(['read:product:collection',
        'write:order:item',
        'read:product:item',
        'put:product:item',
        'read:order:collection'
    ])]
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:product:collection',
        'write:order:item',
        'read:product:item',
        'put:product:item',
        'read:order:collection'
    ])]
    private $type;

    /**
     * @ORM\OneToOne(targetEntity=Product::class, mappedBy="price", cascade={"persist", "remove"})
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        // set the owning side of the relation if necessary
        if ($product->getPrice() !== $this) {
            $product->setPrice($this);
        }

        $this->product = $product;

        return $this;
    }
}
