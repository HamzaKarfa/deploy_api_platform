<?php

namespace App\Utilities\Payment\Factories;

use App\Utilities\Payment\Class\PaypalPayment;
use App\Utilities\Payment\Interfaces\MethodPaymentFactoryInterface;
use App\Utilities\Payment\Interfaces\PaymentInterface;

class PaypalPaymentFactory implements MethodPaymentFactoryInterface
{
    public function getMethodPayment() : PaymentInterface
    {
        return new PaypalPayment();
    }
}