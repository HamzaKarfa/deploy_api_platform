<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetCategoryController  extends AbstractController
{
    public function __construct(protected CategoryRepository $categoryRepository, protected SubCategoryRepository $subCategoryRepository)
    {
        
    }
    public function __invoke()
    {
        $categories = $this->categoryRepository->findAll();
        return $categories;
    }
}