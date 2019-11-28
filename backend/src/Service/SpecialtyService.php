<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;

class SpecialtyService{

    private $specialtyFactory;
    private $entityManager;

    public function __construct(EntityManager $entityManager,
                            \App\Factory\SpecialtyFactory $specialtyFactory){
        $this->specialtyFactory = $specialtyFactory;
        $this->entityManager = $entityManager;
    }

    public function getSpecialties(){
        $specialtiyRepo = $this->specialtyFactory->getSpecialties();
        $specialties = $specialtiyRepo->findAll();
        return $this->sanitazeSpecialties($specialties);
    }

    private function sanitazeSpecialties($specialties){
        $sanatizedSpecialties = array();
        foreach($specialties as $specialty){
            $specialtyData = array(
                'id' => $specialty->getId(),
                'description' => $specialty->getDescription()
            );
            array_push($sanatizedSpecialties, $specialtyData);
        }
        return $sanatizedSpecialties;
    }
}