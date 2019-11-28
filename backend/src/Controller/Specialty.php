<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Specialty{

    private $specialtyService;
    private $entityManager;

    public function __construct(EntityManager $entityManager,
                                \App\Service\SpecialtyService $specialtyService){
        $this->specialtyService = $specialtyService;
        $this->entityManager = $entityManager;
    }

    public function getSpecialties(Request $request, Response $response){
        $specialties = $this->specialtyService->getSpecialties();
        $data = array(
            'error' => false,
            'message' => '',
            'specialties' => $specialties
        );
        return $response->withJson($data)
                        ->withStatus(200);
    }


}