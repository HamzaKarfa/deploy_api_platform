<?php

namespace App\Utilities\Payment\Interfaces;

use App\Utilities\Payment\Interfaces\MethodPaymentFactoryInterface;


interface DirectorFactoryInterfaces
{
    public function createPaymentFactory(): MethodPaymentFactoryInterface;
}