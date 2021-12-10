<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductImageFixtures extends Fixture
{
   
    public function load(ObjectManager $manager)
    {
        $image = new Image();
        $image->setImagePath('https://cdn-s-www.leprogres.fr/images/7A3E01B6-F689-4DCE-A173-A8A4EF72C832/NW_raw/photo-stock-adobe-com-1562264946.jpg');
        $manager->persist($image);
        $manager->flush();
    }
}

