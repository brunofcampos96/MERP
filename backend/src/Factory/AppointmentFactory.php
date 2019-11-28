<?php

namespace App\Factory;

use App\Entity\AppointmentEntity;
use Doctrine\ORM\EntityManager;

class AppointmentFactory{
    
    private $entityManager;

    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function saveAppointment($doctorId, $patientId, $date, $specialtyId){
        $appointment = new AppointmentEntity();
        $patient = $this->entityManager->find('App\Entity\PatientEntity', $patientId);
        $doctor = $this->entityManager->find('App\Entity\DoctorEntity', $doctorId);
        $specialty = $this->entityManager->find('App\Entity\SpecialtyEntity', $specialtyId);
        $appointment->setAppointment($doctor, $patient, $date, $specialty);
        $this->entityManager->persist($appointment);
        $this->entityManager->flush();
        return $appointment->getId();
    }

    public function getAppointments(){
        return $this->entityManager->getRepository('App\Entity\AppointmentEntity');
    }
}