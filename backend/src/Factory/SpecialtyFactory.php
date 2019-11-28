<?php

namespace App\Factory;

use App\Entity\SpecialtyEntity;
use Doctrine\ORM\EntityManager;

class SpecialtyFactory{

    private $entityManager;

    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function getSpecialties(){
        return $this->entityManager->getRepository('App\Entity\SpecialtyEntity');
    }

    public function saveSpecialty($description){
        $specialty = new SpecialtyEntity();
        $specialty->setDescription($description);
        $this->entityManager->persist($specialty);
        $this->entityManager->flush();
        return $specialty->getId();
    }
}