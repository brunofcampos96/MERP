<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class Appointment{

    private $appointmentService;
    private $entityManager;

    public function __construct(EntityManager $entityManager,
                                \App\Service\AppointmentService $appointmentService){
        $this->appointmentService = $appointmentService;
        $this->entityManager = $entityManager;
    }

    public function getAppointments(Request $request, Response $response){
        $queryParams = $request->getQueryParams();
        $doctorId = !empty($queryParams['doctorId']) ? $queryParams['doctorId'] : null;
        $appointments = $this->appointmentService->getAppointments($doctorId);
        $data = array(
            'error' => false,
            'message' => '',
            'appointments' => $appointments
        );
        return $response->withJson($data)
                        ->withStatus(200);
    }

    public function registerAppointment(Request $request, Response $response){
        $this->entityManager->getConnection()->beginTransaction();
        try{
            $body = $request->getParsedBody();
            $doctorId = $body['doctorId'];
            $patientId = $body['patientId'];
            $date = $body['date'];
            $specialtyId = $body['specialtyId'];
            $appointmentId = $this->saveAppointment($doctorId, $patientId, $date, $specialtyId);
            $this->entityManager->getConnection()->commit();
            $data = array(
                'error' => false,
                'message' => 'Consulta registrada com sucesso!',
                'id' => $appointmentId
            );
            return $response->withJson($data)
                            ->withStatus(200);
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

    private function saveAppointment($doctorId, $patientId, $date, $specialtyId){
        return $this->appointmentService->saveAppointment($doctorId, $patientId, $date, $specialtyId);
    }

}