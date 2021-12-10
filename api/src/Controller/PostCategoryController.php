<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Image;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[AsController]
class PostCategoryController extends AbstractController
{
    public function __invoke( Request $request, SluggerInterface $slugger)
    {
        $name= $request->request->get('name');
        $description= $request->request->get('description');
        $uploadedFile = $request->files->get('image');


        $category = new Category();
        $image = new Image();
        
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"image" is required');
        }
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
        // Move the file to the directory where brochures are stored
        try {
            $uploadedFile->move(
                $this->getParameter('categories_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        $image->setImagePath($request->getSchemeAndHttpHost() . '/uploads/categories/' . $newFilename);
        
        $category->setName($name);
        $category->setDescription($description);
        $category->setImage($image);

        return $category;
    }
}