<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Patient{

    private $patientService;
    private $entityManager;

    public function __construct(EntityManager $entityManager,
                                \App\Service\PatientService $patientService){
        $this->patientService = $patientService;
        $this->entityManager = $entityManager;
    }

    public function getPatients(Request $request, Response $response){
        $queryParams = $request->getQueryParams();
        $name = isset($queryParams['name']) ? $queryParams['name'] : null;
        $patients = $this->patientService->getPatients($name);
        $data = array(
            'error' => false,
            'message' => '',
            'patients' => $patients
        );
        return $response->withJson($data)
                        ->withStatus(200);
    }

    public function registerPatient(Request $request, Response $response){
        $this->entityManager->getConnection()->beginTransaction();
        try{
            $input = $request->getParsedBody();
            $cpf = $input['cpf'];
            $name = $input['name'];
            $sex = $input['sex'];
            $birthdate = $input['birthdate'];
            $address = $input['address'];
            $phone = $input['phone'];
            $health_insurance = $input['health_insurance'];
            $number_covenant  = $input['number_covenant'];
            if($this->validPatient($cpf)){
                $patientId = $this->savePatient($cpf, $name, $sex, $birthdate, $address, $phone, $health_insurance, $number_covenant);
                $this->entityManager->getConnection()->commit();
                $data = array(
                    'error' => false,
                    'message' => 'Paciente cadastrado com sucesso!',
                    'id' => $patientId
                );
                return $response->withJson($data)
                                ->withStatus(200);
            }else{
                throw new \Exception("Paciente já cadastrado!");
            }
        }catch(\Exception $e){
            $this->entityManager->getConnection()->rollBack();
            $data = array(
                'error' => true,
                'message' => $e->getMessage()
            );
            return $response->withJson($data)
                            ->withStatus(500);
        }
    }

    private function validPatient($cpf){
        $patient = $this->patientService->getPatient($cpf);
        if(!empty($patient)) return false;
        else return true;
    }

    private function savePatient($cpf, $name, $sex, $birthdate, $address, $phone, $health_insurance, $number_covenant){
        return $this->patientService->savePatient($cpf, $name, $sex, $birthdate, $address, $phone, $health_insurance, $number_covenant);
    }

}