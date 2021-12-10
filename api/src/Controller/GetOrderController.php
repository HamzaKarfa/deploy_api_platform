<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetOrderController  extends AbstractController
{
    public function __invoke(OrderRepository $orderRepository)
    {
        //TO FINIR REQUEST FIND ALL WITH JOIN 
        $order = $orderRepository->getAllOrder();
        dd($order);
        return $order;
    }
}