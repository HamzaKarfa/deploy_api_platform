<?php
namespace App\Tests\Payment;

use App\Utilities\Payment\Factories\DirectorPaymentFactory;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
// abstract class AbstractRequestTest extends ApiTestCase implements RequestTestInterface
use App\Utilities\Payment\Interfaces\DirectorFactoryInterfaces;
use App\Utilities\Payment\Interfaces\MethodPaymentFactoryInterface;
use App\Utilities\Payment\Interfaces\PaymentInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
class PaymentFactoryTest extends ApiTestCase
{
    
    public function testAbstractFactoryWithStripe(){
        $dFactory = new DirectorPaymentFactory('Stripe');
        $factory = $dFactory->createPaymentFactory();
        $payment = $factory->getMethodPayment();
        $response = $payment->paymentIntent(10, $_ENV['STRIPE_SECRET_KEY'] );
        $this->assertInstanceOf(DirectorFactoryInterfaces::class, $dFactory);
        $this->assertInstanceOf(MethodPaymentFactoryInterface::class, $factory);
        $this->assertInstanceOf(PaymentInterface::class, $payment);
        $this->assertInstanceOf(JsonResponse ::class, $response);
    }
        
    public function testAbstractFactoryWithPaypal(){
        $dFactory = new DirectorPaymentFactory('Paypal');
        $factory = $dFactory->createPaymentFactory();
        $payment = $factory->getMethodPayment();
        $response = $payment->paymentIntent(10, $_ENV['STRIPE_SECRET_KEY'] );
        $this->assertInstanceOf(DirectorFactoryInterfaces::class, $dFactory);
        $this->assertInstanceOf(MethodPaymentFactoryInterface::class, $factory);
        $this->assertInstanceOf(PaymentInterface::class, $payment);
        $this->assertInstanceOf(JsonResponse ::class, $response);
    }
}
 