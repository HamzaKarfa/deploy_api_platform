<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


#[AsController]
class PostOrderController  extends AbstractController
{
    public function __construct( )
    {
        
    }
    public function __invoke(Order $order, Request $request, UserRepository $userRepository, ProductRepository $productRepository)
    {
        $order = $request->attributes->get('data');
        $content = $request->toArray();
        foreach ($content['orderProducts'] as $key => $orderProduct) {
            $product = $productRepository->findOneBy(['id'=>$orderProduct['product']['id'] ]);
            $request->attributes->get('data')->getOrderProducts()[$key]->setProduct($product);
            $request->attributes->get('data')->getOrderProducts()[$key]->setCreatedAt(new \DateTimeImmutable);
            $request->attributes->get('data')->getOrderProducts()[$key]->setUpdatedAt(new \DateTimeImmutable);
        }
        $user = $userRepository->findOneBy(['email'=> $content['user_id']['email'],'username'=> $content['user_id']['name']]);
        $order->setUserId($user);
        $order->setUserId($user);
        return($order);
                

    }
}