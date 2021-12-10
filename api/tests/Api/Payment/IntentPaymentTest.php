<?php
namespace App\Tests\Api\Payment;
use App\Tests\Api\Class\Abstract\AbstractRequestTest;

class IntentPaymentTest extends AbstractRequestTest
{
    public function testPaymentIntent()
    {
            $paymentInfo = [
                'paymentMethodType' => "card",
                'currency'=> 'eur',
                'amount' => 10,
                'paymentType'=> 'Stripe',
                'userInfo' => [
                    'email' => 'hamza@gmail.com',
                    'name'=> 'HamzaUser'
                ]
            ];
            $response = $this->httpClientRequest('create-payment-intent', 'POST', $paymentInfo, false);
            $this->assertResponseIsSuccessful();
            $this->assertEquals($response->getStatusCode(), 200);
            $this->assertArrayHasKey('id', $response->toArray());
            $this->assertArrayHasKey('amount', $response->toArray());
            $this->assertArrayHasKey('created', $response->toArray());
            $this->assertArrayHasKey('client_secret', $response->toArray());
    }
}
