<?php

namespace App\Factory;

use App\Entity\DoctorEntity;
use Doctrine\ORM\EntityManager;

class DoctorFactory{

    private $entityManager;

    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function getDoctors(){
        return $this->entityManager->getRepository('App\Entity\DoctorEntity');
    }

    public function saveDoctor($email, $name, $specialties, $crm, $password){
        $doctor = new DoctorEntity();
        $doctor->setDoctor($email, $name, $crm, $password);
        $this->entityManager->persist($doctor);
        $this->setDoctorSpecialties($doctor, $specialties);
        $this->entityManager->flush();
        return $doctor->getId();
    }

    private function setDoctorSpecialties($doctor, $specialties){
        foreach($specialties as $specialty){
            $specialtyInstance = $this->entityManager->find("App\Entity\SpecialtyEntity", $specialty);
            $doctor->setSpecialty($specialtyInstance);
        }
    }

    public function getDoctorLogin($email, $password){
        $doctorsRepo = $this->entityManager->getRepository('App\Entity\DoctorEntity');
        return $doctorsRepo->findBy(array('email' => $email, 'password' => $password));

    }
}