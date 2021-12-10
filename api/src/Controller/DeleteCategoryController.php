<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class DeleteCategoryController  extends AbstractController
{
    public function __construct(protected CategoryRepository $categoryRepository)
    {
        
    }
    public function __invoke(Request $request)
    {
        dd($request);
    }
}