<?php
namespace App\Events;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener {



    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();
        $user = $event->getUser();
        if (!$user instanceof UserInterface) {
            throw new \Exception("User not found", 500);
        }
        $payload['username'] = $user->getUsername();
        $payload['id'] = $user->getId();
        $header = $event->getHeader();
        $event->setData($payload);
        $event->setHeader($header);
    }
}