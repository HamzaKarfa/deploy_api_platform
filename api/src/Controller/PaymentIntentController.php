<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Utilities\Class\Payment;
use App\Utilities\Payment\Factories\DirectorPaymentFactory;

#[AsController]
class PaymentIntentController  extends AbstractController
{
    public function __construct()
    {
        
    }
    public function __invoke(Request $request, UserRepository $userRepository): JsonResponse
    {
        $content = $request->toArray();

        if(!intVal($content["amount"]) > 0){ // Check if amount > 0 
            $e = new JsonException('erreur lors de l\'enregistrement du  payement, veuillez reessayer', 500);
            return (new JsonResponse(['message'=>$e->getMessage()], $e->getCode()));
        }
        if ($content['userInfo']) { //Check if user Exist
            $user = $userRepository->findOneBy(['username'=>$content['userInfo']['name'],'email'=> $content['userInfo']['email']]);
            if (!$user) {
                $e = new JsonException('Le nom d\utilisateur et l\'email ne correspondent à aucun utilisateur', 500);
                return (new JsonResponse(['message'=>$e->getMessage()], $e->getCode()));    
            }
        }else{ 
            $e = new JsonException('Veuiller renseigner votre nom d\'utilisateur et votre email', 500);
            return (new JsonResponse(['message'=>$e->getMessage()], $e->getCode()));
        }

        $directorPaymentFactory = new DirectorPaymentFactory($content["paymentType"]);
        $paymentFactory = $directorPaymentFactory->createPaymentFactory();
        $payment = $paymentFactory->getMethodPayment();
        $jsonReponse = $payment->paymentIntent(intVal($content["amount"]), $this->getParameter('stripe_key_secret'));

        //paymentProcess
        // $jsonReponse = $payment->paymentIntent(intVal($content["amount"]), $this->getParameter('stripe_key_secret'));
        
        return $jsonReponse;

    }
}