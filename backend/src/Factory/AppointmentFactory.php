<?php

namespace App\Factory;

use App\Entity\AppointmentEntity;
use Doctrine\ORM\EntityManager;

class AppointmentFactory{
    
    private $entityManager;

    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function saveAppointment($userId, $patientId, $date){
        $appointment = new AppointmentEntity();
        $patient = $this->entityManager->find('App\Entity\PatientEntity', $patientId);
        $user = $this->entityManager->find('App\Entity\UserEntity', $userId);
        $appointment->setAppointment($user, $patient, $date);
        $this->entityManager->persist($appointment);
        $this->entityManager->flush();
        return $appointment->getId();
    }

    public function getAppointments(){
        return $this->entityManager->getRepository('App\Entity\AppointmentEntity');
    }
}