<?php

namespace App\Entity;
/** 
 * @Entity
 * @Table(name="user")
 */
class UserEntity{


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
    /** @Column(length=100) */
    private $name;
    /** @Column(length=32) */
    private $password;


    public function __construct() {
    }
    
    public function setUser($email, $name, $password){
        $this->email = $email;
        $this->name = $name;
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