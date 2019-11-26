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

    public function saveUser($email, $name, $specialties, $crm, $password){
        $user = new UserEntity();
        $user->setUser($email, $name, $crm, $password);
        $this->entityManager->persist($user);
        $this->setUserSpecialties($user, $specialties);
        $this->entityManager->flush();
        return $user->getId();
    }

    private function setUserSpecialties($user, $specialties){
        foreach($specialties as $specialty){
            $specialtyInstance = $this->entityManager->find("App\Entity\SpecialtyEntity", $specialty);
            $user->setSpecialty($specialtyInstance);
        }
    }

    public function getUserLogin($email, $password){
        $usersRepo = $this->entityManager->getRepository('App\Entity\UserEntity');
        return $usersRepo->findBy(array('email' => $email, 'password' => $password));

    }
}