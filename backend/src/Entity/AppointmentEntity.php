<?php

namespace App\Entity;
/**
 * @Entity
 * @Table(name="appointment")
 */
class AppointmentEntity{

    /**
     * One Appointment has one Specialty
     * @OneToOne(targetEntity="SpecialtyEntity")
     * @JoinColumn(name="specialty_id", referencedColumnName="id")
     */
    private $specialty;

    /**
     * Many appointments have one Doctor. This is the owning side.
     * @ManyToOne(targetEntity="DoctorEntity", inversedBy="appointment")
     * @JoinColumn(name="doctor_id", referencedColumnName="id")
     */
    private $doctor;

    /**
     * Many appointments have one patient. This is the owning side.
     * @ManyToOne(targetEntity="PatientEntity", inversedBy="appointment")
     * @JoinColumn(name="patient_id", referencedColumnName="id")
     */
    private $patient;

    public function setAppointment($doctor, $patient, $date, $specialty){
        $this->doctor = $doctor;
        $this->patient = $patient;
        $this->date = $date;
        $this->specialty = $specialty;
    }

    /**
     * @Id
     * @Column(type="integer", length=10)
     * @GeneratedValue
     */
    private $id;
    /**
     * @Column(type="datetime")
     */
    private $date;


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get many appointments have one patient. This is the owning side.
     */ 
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * Get many appointments have one doctor. This is the owning side.
     */ 
    public function getDoctor()
    {
        return $this->doctor;
    }

    /**
     * Get specialty
     */ 
    public function getSpecialty()
    {
        return $this->specialty;
    }
}