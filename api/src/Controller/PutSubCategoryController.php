<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\SubCategory;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[AsController]
class PutSubCategoryController extends AbstractController
{
    public function __invoke( Request $request, SluggerInterface $slugger,  CategoryRepository $categoryRepository)
    {   
        return $request;
        $name= $request->request->get('name');
        $categoryId= $request->request->get('categories');
        $uploadedFile = $request->files->get('image');
        $category = $categoryRepository->find($categoryId);

        if ($uploadedFile) {
            $image = new Image();
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
            // Move the file to the directory where brochures are stored
            try {
                $uploadedFile->move(
                    $this->getParameter('sub_categories_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
                throw $e;
            }
            $image->setImagePath($request->getSchemeAndHttpHost() . '/uploads/sub_categories/' . $newFilename);
        }
    }
}