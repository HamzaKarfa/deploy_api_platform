<?php
namespace App\Utilities\Payment\Interfaces;

interface MethodPaymentFactoryInterface
{
    public function getMethodPayment(): PaymentInterface;
}