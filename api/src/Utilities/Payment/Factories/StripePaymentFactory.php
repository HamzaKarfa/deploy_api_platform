<?php

namespace App\Utilities\Payment\Factories;

use App\Utilities\Payment\Class\StripePayment;
use App\Utilities\Payment\Interfaces\MethodPaymentFactoryInterface;
use App\Utilities\Payment\Interfaces\PaymentInterface;

class StripePaymentFactory implements MethodPaymentFactoryInterface
{
    public function getMethodPayment() : PaymentInterface
    {
        return new StripePayment();
    }
}