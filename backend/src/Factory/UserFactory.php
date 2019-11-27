<?php

namespace App\Factory;

use App\Entity\UserEntity;
use Doctrine\ORM\EntityManager;

class UserFactory{

    private $entityManager;

    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function getUsers(){
        return $this->entityManager->getRepository('App\Entity\UserEntity');
    }

    public function saveUser($email, $name, $password){
        $user = new UserEntity();
        $user->setUser($email, $name, $password);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user->getId();
    }

    public function getUserLogin($email, $password){
        $usersRepo = $this->entityManager->getRepository('App\Entity\UserEntity');
        return $usersRepo->findBy(array('email' => $email, 'password' => $password));

    }
}