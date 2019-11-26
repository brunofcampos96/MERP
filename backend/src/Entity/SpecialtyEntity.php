<?php

namespace App\Entity;
/**
 * @Entity
 * @Table(name="specialty")
 */
class SpecialtyEntity{

    /**
     * @Id
     * @Column(type="integer", length=10)
     * @GeneratedValue
     */
    private $id;
    /**
     * @Column(length=140)
    */
    private $description;

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

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