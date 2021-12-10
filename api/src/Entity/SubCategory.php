<?php

namespace App\Entity;
use App\Repository\SubCategoryRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\PostSubCategoryController;
use App\Controller\PutSubCategoryController;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SubCategoryRepository::class)
 */
#[
    ApiResource(
        collectionOperations:[
            'get'=>[
                'normalization_context'=>['groups'=>['read:sub_categories:collection']],
            ],
            'post'=>[
                'method'=>'POST',
                'controller'=> PostSubCategoryController::class,
                'deserialize'=>false,
                'validate'=>false,
                'openapi_context' => [
                    'requestBody' => [
                        'content' => [
                            'multipart/form-data' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'image' => [
                                            'type' => 'string',
                                            'format' => 'binary',
                                        ],
                                        'name' => [
                                            'type' => 'string',
                                            'format' => 'string',
                                        ],
                                        'category'=>[
                                            'type' => 'integer',
                                            'format' => 'integer',
                                        ]
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        itemOperations:[
            'put'=>[
                'denormalization_context'=> ['groups'=>['put:sub_categories:item']]
            ],
            'delete',
            'get'=>[
                'normalization_context'=>['groups'=>['read:sub_categories:item']],
            ],
        ]
    )
]
class SubCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:product:collection',
        'read:sub_categories:collection',
        'read:sub_categories:item',
        'read:categories:collection',
        'read:categories:items',
        'read:product:item',
        
    ])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:product:collection',
        'read:sub_categories:collection',
        'read:sub_categories:item',
        'read:categories:collection',
        'read:categories:items',
        'put:sub_categories:item',
        'read:product:item',

    ])]
    private $name;

    
    /**
     * @ORM\OneToOne(targetEntity=Image::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    #[Groups(['read:sub_categories:collection',
        'read:categories:collection',
        'read:sub_categories:item',
    ])]
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="subCategories")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:product:collection',
        'read:sub_categories:collection',
        'read:sub_categories:item',
        'put:sub_categories:item'
    ])]
    private $category;

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage( Image $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
