<?php
namespace App\Utilities\Payment\Class;
    
use App\Utilities\Payment\Interfaces\PaymentInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class PaypalPayment implements PaymentInterface
{
    public function paymentIntent(int $amount, string $stripeSecretKey): JsonResponse
    {
        // Payement Process Paypal
       return new JsonResponse();
    }
}