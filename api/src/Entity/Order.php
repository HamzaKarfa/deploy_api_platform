<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\PostOrderController;
use App\Controller\GetOrderController;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Security\Core\Authentication\RememberMe\PersistentToken;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
// =>[
//     'controller' => GetOrderController::class
// ]
#[ApiResource(
    collectionOperations:[
        'get'=>[
            'normalization_context'=> ['groups'=>[ 'read:order:collection']]
        ],
        'post'=>[
            'denormalization_context'=>['groups'=>['write:order:item']],
            'controller' => PostOrderController::class,
        ]
    ],
    itemOperations:[
        'get'=>[
            'normalization_context'=> ['groups'=>[ 'read:item:collection']]
        ]
    ]
)]
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */

    #[Groups(['write:order:item','read:order:collection','read:item:collection'])]
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['write:order:item','read:order:collection','read:item:collection'])]
    private $user_id;

    /**
     * @ORM\OneToMany(targetEntity=OrderProduct::class, mappedBy="order_id", cascade={"persist"})
     */
    #[Groups(['write:order:item','read:order:collection','read:item:collection'])]
    private $orderProducts;

    public function __construct()
    {
        $this->orderProducts = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return OrderProduct[]
     */
    public function getOrderProducts(): ArrayCollection
    {
        if($this->orderProducts instanceof PersistentCollection)
        {
            return $this->orderProducts->toArray();
        }
        return $this->orderProducts;
    }

    public function addOrderProduct(OrderProduct $orderProduct): self
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts[] = $orderProduct;
            $orderProduct->setOrderId($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProducts->removeElement($orderProduct)) {
            // set the owning side to null (unless already changed)
            if ($orderProduct->getOrderId() === $this) {
                $orderProduct->setOrderId(null);
            }
        }

        return $this;
    }

}
