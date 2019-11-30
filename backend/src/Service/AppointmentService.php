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

    public function saveAppointment($doctorId, $patientId, $date, $specialtyId){
        $date = str_replace('T', " ", $date);
        $date = \DateTime::createFromFormat('Y-m-d H:i', $date);
        return $this->appointmentFactory->saveAppointment($doctorId, $patientId, $date, $specialtyId);
    }

    public function getAppointments($doctorId){
        $appointmentRepo = $this->appointmentFactory->getAppointments();
        if(empty($doctorId)) $appointments = $appointmentRepo->findBy(array(), array('date' => 'ASC'));
        else {
            $doctorAppointments = $this->appointmentFactory->getDoctorAppointments($doctorId);
            $appointments = $appointmentRepo->findBy(array('id' => $doctorAppointments), array('date' => 'ASC'));
        }
        return $this->sanatizeAppointments($appointments);
    }

    private function sanatizeAppointments($appointments){
        $sanatizedAppointments = array();
        foreach($appointments as $appointment){
            $appointmentData = array(
                'id' => $appointment->getId(),
                'doctor' => array(
                    'name' => $appointment->getDoctor()->getName(),
                    'crm' => $appointment->getDoctor()->getCrm(),
                    'email' => $appointment->getDoctor()->getEmail()
                ),
                'patient' => array(
                    'cpf' => $appointment->getPatient()->getCpf(),
                    'name' => $appointment->getPatient()->getName(),
                    'birthdate' => $appointment->getPatient()->getBirthdate(),
                    'phone' => $appointment->getPatient()->getPhone(),
                    'health_insurance' => $appointment->getPatient()->getHealth_insurance(),
                    'number_covenant' => $appointment->getPatient()->getNumber_covenant()
                ),
                'specialty' => array(
                    'description' => $appointment->getSpecialty()->getDescription(),
                ),
                'date' => $appointment->getDate()->format('d/m/Y H:i')
            );
            array_push($sanatizedAppointments, $appointmentData);
        }
        return $sanatizedAppointments;
    }

}