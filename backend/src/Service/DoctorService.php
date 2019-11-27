<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;

class DoctorService{

    private $doctorFactory;
    private $entityManager;

    public function __construct(EntityManager $entityManager,
                            \App\Factory\DoctorFactory $doctorFactory){
        $this->doctorFactory = $doctorFactory;
        $this->entityManager = $entityManager;
    }

    public function getDoctor($email){
        $doctorRepo = $this->doctorFactory->getDoctors();
        $doctors = $doctorRepo->findBy(array('email' => $email));
        return $this->sanitazeDoctors($doctors);
    }

    public function saveDoctor($email, $name, $specialties, $crm, $password){
        $password = md5($password);
        return $this->doctorFactory->saveDoctor($email, $name, $specialties, $crm, $password);
    }

    public function getDoctorLogin($email, $password){
        $password = md5($password);
        return $this->doctorFactory->getDoctorLogin($email, $password);
    }

    public function getDoctors($name){
        $doctorRepo = $this->doctorFactory->getDoctors();
        if(empty($name)) $doctors = $doctorRepo->findAll();
        else $doctors = $doctorRepo->findBy(array('name' => $name));
        return $this->sanitazeDoctors($doctors);
    }

    private function sanitazeDoctors($doctors){
        $sanatizedDoctors = array();
        foreach($doctors as $doctor){
            $doctorData = array(
                'id' => $doctor->getId(),
                'email' => $doctor->getEmail(),
                'name' => $doctor->getName(),
                'crm' => $doctor->getCrm(),
                'specialities' => array(),
                'appointments' => array()
            );
            $specialties = $doctor->getSpecialities();
            foreach($specialties as $specialty){
                $specialtyData = array(
                    'id' => $specialty->getId(),
                    'description' => $specialty->getDescription()
                );
                array_push($doctorData['specialities'], $specialtyData);
            }
            $appointments = $doctor->getAppointments();
            foreach($appointments as $appointment){
                $appointmentData = array(
                    'id' => $appointment->getId(),
                    'patient' => array(
                        'name' => $appointment->getPatient()->getName()
                    ),
                    'specialty' => $appointment->getSpecialty()->getDescription()
                );
                array_push($doctorData['appointments'], $appointmentData);
            } 
            array_push($sanatizedDoctors, $doctorData);
        }
        return $sanatizedDoctors;
    }

}