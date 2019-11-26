<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class User{

    private $userService;
    private $entityManager;

    public function __construct(EntityManager $entityManager,
                                \App\Service\UserService $userService){
        $this->userService = $userService;
        $this->entityManager = $entityManager;
    }

    public function getUsers(Request $request, Response $response){
        $queryParams = $request->getQueryParams();
        $name = isset($queryParams['name']) ? $queryParams['name'] : null;
        $users = $this->userService->getUsers($name);
        $data = array(
            'error' => false,
            'message' => '',
            'users' => $users
        );
        return $response->withJson($data)
                        ->withStatus(200);
    }

    public function registerUser(Request $request, Response $response){
        $this->entityManager->getConnection()->beginTransaction();
        try{
            $input = $request->getParsedBody();
            $email = $input['email'];
            $name = $input['name'];
            $specialties = $input['specialties']; 
            $crm = $input['crm'];
            $password = $input['password'];
            if($this->validUser($email)){
                $userId = $this->saveUser($email, $name, $specialties, $crm, $password);
                $this->entityManager->getConnection()->commit();
                $data = array(
                    'error' => false,
                    'message' => 'Usuário cadastrado com sucesso!',
                    'id' => $userId
                );
                return $response->withJson($data)
                                ->withStatus(200);
            }else{
                throw new \Exception("Usuário já cadastrado!");
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

    public function login(Request $request, Response $response){
        try{
            $input = $request->getParsedBody();
            $email = $input['email'];
            $password = $input['password'];
            if($this->validLogin($email, $password)){
                $data = array(
                    'error' => false,
                    'validLogin' => true,
                    'message' => ''
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

    private function validUser($email){
        $user = $this->userService->getUser($email);
        if(!empty($user)) return false;
        else return true;
    }

    private function validLogin($email, $password){
        $user = $this->userService->getUserLogin($email, $password);
        if(!empty($user)) return true;
        else return false;
    }

    private function saveUser($email, $name, $specialties, $crm, $password){
        return $this->userService->saveUser($email, $name, $specialties, $crm, $password);
    }

}