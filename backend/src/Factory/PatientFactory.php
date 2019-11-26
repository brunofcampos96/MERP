<?php

namespace App\Factory;

use App\Entity\PatientEntity;
use Doctrine\ORM\EntityManager;

class PatientFactory{

    private $entityManager;

    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function getPatients(){
        return $this->entityManager->getRepository('App\Entity\PatientEntity');
    }

    public function savePatient($cpf, $name, $sex, $birthdate, $address, $phone, $health_insurance, $number_covenant){
        $patient = new PatientEntity();
        $patient->setPatient($cpf, $name, $sex, $birthdate, $address, $phone, $health_insurance, $number_covenant);
        $this->entityManager->persist($patient);
        $this->entityManager->flush();
        return $patient->getId();
    }
}