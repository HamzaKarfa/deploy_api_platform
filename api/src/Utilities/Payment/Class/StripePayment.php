<?php
namespace App\Utilities\Payment\Class;
    
use App\Utilities\Payment\Interfaces\PaymentInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class StripePayment implements PaymentInterface
{
    public function paymentIntent(int $amount, string $stripeSecretKey): JsonResponse
    {
        try{
            \Stripe\Stripe::setApiKey($stripeSecretKey);

            $intent = \Stripe\PaymentIntent::create([
            'amount' => intVal($amount)*100,
            'currency' => 'eur',
            'payment_method_types' => ['card'],
            ]);
            return new JsonResponse($intent);
        }
        catch(\Exception $e){
            return (new JsonResponse([$e->getMessage()], $e->getCode()));
        }
    }
}