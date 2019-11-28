<?php

namespace App\Factory;

use App\Entity\DoctorEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;

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

    public function getDoctorsBySpecialty($specialty){
        $data = array();
        $sql = '
            SELECT D.id 
              FROM doctor D
              JOIN doctor_specialties DS
                ON DS.doctor_id = D.id
             WHERE DS.specialty_id = :SPECIALTY
        ';
        $params = array(
            'SPECIALTY' => $specialty
        );
        $result = $this->entityManager->getConnection()->fetchAll($sql, $params);
        foreach($result as $doctor){
            array_push($data, $doctor['id']);
        }
        return $data;
    }
}