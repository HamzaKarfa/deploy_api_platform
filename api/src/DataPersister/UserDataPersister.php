<?php
// src/DataPersister/UserDataPersister.php

namespace App\DataPersister;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Security\PasswordHasher;
/**
 *
 */
class UserDataPersister implements ContextAwareDataPersisterInterface
{

    public function __construct(
        private EntityManagerInterface $_entityManager,
        private PasswordHasher $_passwordEncoder
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    /**
     * @param User $data
     */
    public function persist($data, array $context = [])
    {
        if ($data->getPlainPassword()) {
            $hashedPassword =  $this->_passwordEncoder->hash(
                    $data->getPlainPassword(),
            );
   
            if ($this->_passwordEncoder->verify($hashedPassword, $data->getPlainPassword())) {
                $data->setPassword($hashedPassword);
                $data->eraseCredentials();
            }

        }

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}