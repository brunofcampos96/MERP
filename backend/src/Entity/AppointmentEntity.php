<?php

namespace App\Entity;
/**
 * @Entity
 * @Table(name="appointment")
 */
class AppointmentEntity{

    /**
     * Many appointments have one user. This is the owning side.
     * @ManyToOne(targetEntity="UserEntity", inversedBy="appointment")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * Many appointments have one patient. This is the owning side.
     * @ManyToOne(targetEntity="PatientEntity", inversedBy="appointment")
     * @JoinColumn(name="patient_id", referencedColumnName="id")
     */
    private $patient;

    public function setAppointment($user, $patient, $date){
        $this->user = $user;
        $this->patient = $patient;
        $this->date = $date;
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
     * Get many appointments have one user. This is the owning side.
     */ 
    public function getUser()
    {
        return $this->user;
    }
}