<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;

class AppointmentService{

    private $appointmentFactory;
    private $entityManager;

    public function __construct(EntityManager $entityManager,
                            \App\Factory\AppointmentFactory $appointmentFactory){
        $this->appointmentFactory = $appointmentFactory;
        $this->entityManager = $entityManager;
    }

    public function saveAppointment($userId, $patientId, $date){
        $date = \DateTime::createFromFormat('d/m/Y H:i:s', $date);
        return $this->appointmentFactory->saveAppointment($userId, $patientId, $date);
    }

    public function getAppointments(){
        $appointmentRepo = $this->appointmentFactory->getAppointments();
        $appointments = $appointmentRepo->findAll();
        return $this->sanatizeAppointments($appointments);
    }

    private function sanatizeAppointments($appointments){
        $sanatizedAppointments = array();
        foreach($appointments as $appointment){
            $appointmentData = array(
                'id' => $appointment->getId(),
                'user' => array(
                    'name' => $appointment->getUser()->getName(),
                    'crm' => $appointment->getUser()->getCrm(),
                    'email' => $appointment->getUser()->getEmail()
                ),
                'patient' => array(
                    'cpf' => $appointment->getPatient()->getCpf(),
                    'name' => $appointment->getPatient()->getName(),
                    'birthdate' => $appointment->getPatient()->getBirthdate(),
                    'phone' => $appointment->getPatient()->getPhone(),
                    'health_insurance' => $appointment->getPatient()->getHealth_insurance(),
                    'number_covenant' => $appointment->getPatient()->getNumber_covenant()
                ),
                'date' => $appointment->getDate()
            );
            array_push($sanatizedAppointments, $appointmentData);
        }
        return $sanatizedAppointments;
    }

}