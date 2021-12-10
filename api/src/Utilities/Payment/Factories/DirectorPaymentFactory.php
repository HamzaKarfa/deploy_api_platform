<?php 

namespace App\Utilities\Payment\Factories;
use App\Utilities\Payment\Interfaces\MethodPaymentFactoryInterface;

use App\Utilities\Payment\Interfaces\DirectorFactoryInterfaces;
use Exception;

class DirectorPaymentFactory implements DirectorFactoryInterfaces
{
    protected $type;

    public function __construct($type){ 
        $this->type = ucfirst($type);
    }
    public function createPaymentFactory() :MethodPaymentFactoryInterface 
    {
        $factoryName = "App\Utilities\Payment\Factories\\" .ucfirst($this->type)."PaymentFactory";
        if (!class_exists($factoryName)) {
            throw new Exception("Sorry, ".ucfirst($this->type)."PaymentFactory"." class does not exist! ", 404);
        }
        return new $factoryName;
    }
}