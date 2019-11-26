<?php

namespace App\Entity;
/** 
 * @Entity
 * @Table(name="user")
 */
class UserEntity{

    /**
     * Many Users have Many Specialtys.
     * @ManyToMany(targetEntity="SpecialtyEntity")
     * @JoinTable(name="users_specialties",
     *      joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="specialty_id", referencedColumnName="id")}
     * )
     */
    private $specialties;

     /**
     * One User has many appointments. This is the inverse side.
     * @OneToMany(targetEntity="AppointmentEntity", mappedBy="UserEntity")
     */
    private $appointments;

    public function __construct() {
        $this->specialties = new \Doctrine\Common\Collections\ArrayCollection();
        $this->appointments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setSpecialty(SpecialtyEntity $specialty){
        $this->specialties[] = $specialty;
    }

    public function getSpecialities(){
        return $this->specialties;
    }

    public function setAppintment(AppointmentEntity $appointment){
        $this->appointments[] = $appointment;
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
     * @Column(length=60) 
     */
    private $email;
    /** @Column(length=100, nullable=true) */
    private $name;
    /** @Column(length=50, nullable=true) */
    private $crm;
    /** @Column(length=32, nullable=true) */
    private $password;
    
    public function setUser($email, $name, $crm, $password){
        $this->email = $email;
        $this->name = $name;
        $this->crm = $crm;
        $this->password = $password;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of crm
     */ 
    public function getCrm()
    {
        return $this->crm;
    }

    /**
     * Set the value of crm
     *
     * @return  self
     */ 
    public function setCrm($crm)
    {
        $this->crm = $crm;

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
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

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