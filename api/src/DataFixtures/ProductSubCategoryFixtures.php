<?php

namespace App\DataFixtures;

use App\Entity\SubCategory;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\CategoryRepository;

class ProductSubCategoryFixtures extends Fixture
{
    protected $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository =  $categoryRepository;
    }

    public function load(ObjectManager $manager)
    {
        $categories = $this->categoryRepository->findAll();

        $subCategoriesNames1 = [
            ['Fruits','Fruits.jpg' ],
            ['Légumes','Legumes.jpg'],
            ['Fruits et légumes exotiques','FL_exotiques.jpg'],
            ['Herbes aromatiques et condiments','Herbes.jpg']
        ];
        $subCategoriesNames2 = [
            ['Epicerie salée','salee.jpg'],
            ['Epicerie sucrée','sucree.jpg'],
            ['Vrac','vrac.jpg'],
            ['Boisson et jus','boisson.jpg'],
            ['Vins et bières','vins.jpg'],
            ['Produits bio','bio.jpg']
        ];
        $subCategoriesNames3 = [
            ['La fromagerie','fromagerie.jpg'],
            ['La crèmerie','cremerie.jpg']
        ];
        $subCategoriesNames4 = [
            ['Boucherie','boucherie.jpg'],
            ['Charcuterie','charcuterie.jpg'],
            ['Produits de saison','saison.jpg']
        ];
        $subCategoriesNames5 = [
            ['Poisson entier et en filets','poisson.jpg'],
            ['Fruit de mer, crustasé et céphalopodes','fruit-de-mer.jpg'],
            ['Le traiteur de la mer','traiteur-mer.jpg']
        ];
        $allSubCategories = [
            $subCategoriesNames1,
            $subCategoriesNames2,
            $subCategoriesNames3,
            $subCategoriesNames4,
            $subCategoriesNames5
        ];
        foreach ($allSubCategories as $key => $subCategoriesNames) {
            foreach ($subCategoriesNames as $subCategoryName) {
                $subCategory = new SubCategory();
                $subCategory->setName($subCategoryName[0])
                            ->setImage($subCategoryName[1])
                            ->setCategory($categories[$key]);
                $manager->persist($subCategory);
            }
            $manager->flush();
        }
    }
}

