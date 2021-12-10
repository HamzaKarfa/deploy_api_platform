<?php

namespace App\Utilities\Payment\Interfaces;


use Symfony\Component\HttpFoundation\JsonResponse;

interface PaymentInterface
{
    public function paymentIntent(int $amount, string $stripeSecretKey ): JsonResponse;
}