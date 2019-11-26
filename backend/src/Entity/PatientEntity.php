<?php

namespace App\Entity;
/**
 * @Entity
 * @Table(name="patient")
 */
class PatientEntity{

     /**
     * One Patient has many appointments. This is the inverse side.
     * @OneToMany(targetEntity="AppointmentEntity", mappedBy="patient")
     */
    private $appointments;

    public function __construct() {
        $this->appointments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getAppointments(){
        return $this->appointments;
    }

    /**
     * @Id 
     * @Column(type="integer", length=10)
     * @GeneratedValue
    */
    private $id;
    /**
     * @Column(length=11)
     */
    private $cpf;
    /**
     * @Column(length=140)
     */
    private $name;
    /**
     * @Column(length=1, nullable=true)
     */
    private $sex;
    /**
     * @Column(type="date")
     */
    private $birthdate;
    /**
     * @Column(length=140)
     */
    private $address;
    /**
     * @Column(length=11, nullable=true)
     */
    private $phone;
    /**
     * @Column(length=60, nullable=true)
     */
    private $health_insurance;
    /**
     * @Column(length=60, nullable=true)
     */
    private $number_covenant;

    public function setPatient($cpf, $name, $sex, $birthdate, $address, $phone, $health_insurance, $number_covenant){
        $this->cpf = $cpf;
        $this->name = $name;
        $this->sex = $sex;
        $this->birthdate = $birthdate;
        $this->address = $address;
        $this->phone = $phone;
        $this->health_insurance = $health_insurance;
        $this->number_covenant = $number_covenant;
    }
    

    /**
     * Get the value of cpf
     */ 
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set the value of cpf
     *
     * @return  self
     */ 
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of sex
     */ 
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set the value of sex
     *
     * @return  self
     */ 
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get the value of birthdate
     */ 
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set the value of birthdate
     *
     * @return  self
     */ 
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get the value of address
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of health_insurance
     */ 
    public function getHealth_insurance()
    {
        return $this->health_insurance;
    }

    /**
     * Set the value of health_insurance
     *
     * @return  self
     */ 
    public function setHealth_insurance($health_insurance)
    {
        $this->health_insurance = $health_insurance;

        return $this;
    }

    /**
     * Get the value of number_covenant
     */ 
    public function getNumber_covenant()
    {
        return $this->number_covenant;
    }

    /**
     * Set the value of number_covenant
     *
     * @return  self
     */ 
    public function setNumber_covenant($number_covenant)
    {
        $this->number_covenant = $number_covenant;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }
}