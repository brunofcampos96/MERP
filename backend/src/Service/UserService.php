<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;

class UserService{

    private $userFactory;
    private $entityManager;

    public function __construct(EntityManager $entityManager,
                            \App\Factory\UserFactory $userFactory){
        $this->userFactory = $userFactory;
        $this->entityManager = $entityManager;
    }

    public function getUser($email){
        $usersRepo = $this->userFactory->getUsers();
        return $usersRepo->findBy(array('email' => $email));
    }

    public function saveUser($email, $name, $specialties, $crm, $password){
        $password = md5($password);
        return $this->userFactory->saveUser($email, $name, $specialties, $crm, $password);
    }

    public function getUserLogin($email, $password){
        $password = md5($password);
        return $this->userFactory->getUserLogin($email, $password);
    }

    public function getUsers($name){
        $usersRepo = $this->userFactory->getUsers();
        if(empty($name)) $users = $usersRepo->findAll();
        else $users = $usersRepo->findBy(array('name' => $name));
        return $this->sanitazeUsers($users);
    }

    private function sanitazeUsers($users){
        $sanatizedUsers = array();
        foreach($users as $user){
            $userData = array(
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'name' => $user->getName(),
                'crm' => $user->getCrm(),
                'specialities' => array(),
                'appointments' => array()
            );
            $specialties = $user->getSpecialities();
            foreach($specialties as $specialty){
                $specialtyData = array(
                    'id' => $specialty->getId(),
                    'description' => $specialty->getDescription()
                );
                array_push($userData['specialities'], $specialtyData);
            }
            $appointments = $user->getAppointments();
            /* foreach($appointments as $appointment){
                $appointmentData = array(
                    'id' => $specialty->getId(),
                    'description' => $specialty->getDescription()
                );
                array_push($userData['appointments'], $appointmentData);
            } */
            array_push($sanatizedUsers, $userData);
        }
        return $sanatizedUsers;
    }

}