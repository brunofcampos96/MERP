<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;

class PatientService{

    private $patientFactory;
    private $entityManager;

    public function __construct(EntityManager $entityManager,
                            \App\Factory\PatientFactory $patientFactory){
        $this->patientFactory = $patientFactory;
        $this->entityManager = $entityManager;
    }

    public function getPatients($name){
        $patientsRepo = $this->patientFactory->getPatients();
        if(empty($name)) $patients = $patientsRepo->findAll();
        else $patients = $patientsRepo->findBy(array('name' => $name));
        return $this->sanitazePatients($patients);
    }

    public function getPatient($cpf){
        $cpf = preg_replace('/[^0-9\s]/', '', $cpf);
        $patientsRepo = $this->patientFactory->getPatients();
        return $patientsRepo->findBy(array('cpf' => $cpf));
    }

    public function savePatient($cpf, $name, $sex, $birthdate, $address, $phone, $health_insurance, $number_covenant){
        $cpf = preg_replace('/[^0-9\s]/', '', $cpf);
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $birthdate = \DateTime::createFromFormat('Y-m-d', $birthdate);
        return $this->patientFactory->savePatient($cpf, $name, $sex, $birthdate, $address, $phone, $health_insurance, $number_covenant);
    }

    private function sanitazePatients($patients){
        $sanatizedPatients = array();
        foreach($patients as $patient){
            $patientData = array(
                'id' => $patient->getId(),
                'cpf' => $patient->getCpf(),
                'name' => $patient->getName(),
                'sex' => $patient->getSex(),
                'birthdate' => $patient->getBirthdate(),
                'address' => $patient->getAddress(),
                'phone' => $patient->getPhone(),
                'health_insurance' => $patient->getHealth_insurance(),
                'number_covenant' => $patient->getNumber_covenant()
            );
            $appointments = $patient->getAppointments();
            /* foreach($appointments as $appointment){
                $appointmentData = array(
                    'id' => $specialty->getId(),
                    'description' => $specialty->getDescription()
                );
                array_push($userData['appointments'], $appointmentData);
            } */
            array_push($sanatizedPatients, $patientData);
        }
        return $sanatizedPatients;
    }
}