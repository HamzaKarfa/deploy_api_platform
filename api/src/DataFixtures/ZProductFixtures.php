<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\SubCategoryRepository;
use App\Repository\ImageRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ZProductFixtures extends Fixture
{
    protected $subCategoryRepository;
    protected $imageRepository;
    public function __construct(
        SubCategoryRepository $subCategoryRepository,
        ImageRepository $imageRepository
    )
    {
        $this->subCategoryRepository =  $subCategoryRepository;
        $this->imageRepository =  $imageRepository;
    }
    public function load(ObjectManager $manager)
    {
        $subCategories = $this->subCategoryRepository->findAll();

        foreach ($subCategories as $subCategory) {
            for ($i=1; $i < 10; $i++) {
                $product = new Product();
                $product->setName('Product'. $i)
                        ->setPrice($i)
                        ->setOrigin('France')
                        ->setSubCategory($subCategory)
                        ->setCreatedAt(new \DateTime())
                        ->setUpdatedAt(new \DateTime());
                
                $manager->persist($product);
                $manager->flush();
            }
        }
    }
}

