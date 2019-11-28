<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Doctor{

    private $doctorService;
    private $entityManager;

    public function __construct(EntityManager $entityManager,
                                \App\Service\DoctorService $doctorService){
        $this->doctorService = $doctorService;
        $this->entityManager = $entityManager;
    }

    public function getDoctors(Request $request, Response $response){
        $queryParams = $request->getQueryParams();
        $name = isset($queryParams['name']) ? $queryParams['name'] : null;
        $doctors = $this->doctorService->getDoctors($name);
        $data = array(
            'error' => false,
            'message' => '',
            'doctors' => $doctors
        );
        return $response->withJson($data)
                        ->withStatus(200);
    }

    public function registerDoctor(Request $request, Response $response){
        $this->entityManager->getConnection()->beginTransaction();
        try{
            $input = $request->getParsedBody();
            $email = $input['email'];
            $name = $input['name'];
            $specialties = $input['specialties']; 
            $crm = $input['crm'];
            $password = $input['password'];
            if($this->validDoctor($email)){
                $userId = $this->saveDoctor($email, $name, $specialties, $crm, $password);
                $this->entityManager->getConnection()->commit();
                $data = array(
                    'error' => false,
                    'message' => 'Médico cadastrado com sucesso!',
                    'id' => $userId
                );
                return $response->withJson($data)
                                ->withStatus(200);
            }else{
                throw new \Exception("Médico já cadastrado!");
            }
        }catch(\Exception $e){
            $this->entityManager->getConnection()->rollBack();
            $data = array(
                'error' => true,
                'message' => $e->getMessage()
            );
            return $response->withJson($data)
                            ->withStatus(200);
        }
    }

    public function login(Request $request, Response $response){
        try{
            $input = $request->getParsedBody();
            $email = $input['email'];
            $password = $input['password'];
            if($this->validLogin($email, $password)){
                $doctor = $this->getDoctor($email);
                $data = array(
                    'error' => false,
                    'validLogin' => true,
                    'message' => '',
                    'doctor' => $doctor
                );
                return $response->withJson($data)
                                ->withStatus(200);
            }else{
                throw new \Exception("Email e/ou senha inválido(s)!");
            }
        }catch(\Exception $e){
            $data = array(
                'error' => true,
                'validLogin' => false,
                'message' => $e->getMessage()
            );
            return $response->withJson($data)
                            ->withStatus(200);
        }
    }

    private function validDoctor($email){
        $doctor = $this->doctorService->getDoctor($email);
        if(!empty($doctor)) return false;
        else return true;
    }

    private function validLogin($email, $password){
        $doctor = $this->doctorService->getDoctorLogin($email, $password);
        if(!empty($doctor)) return true;
        else return false;
    }

    private function saveDoctor($email, $name, $specialties, $crm, $password){
        return $this->doctorService->saveDoctor($email, $name, $specialties, $crm, $password);
    }

    private function getDoctor($email){
        $doctor = $this->doctorService->getDoctor($email);
        return $doctor[0];
    }

}