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
        $users = $usersRepo->findBy(array('email' => $email));
        return $this->sanitazeUsers($users);
    }

    public function saveUser($email, $name, $password){
        $password = md5($password);
        return $this->userFactory->saveUser($email, $name, $password);
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
                'appointments' => array()
            );
            array_push($sanatizedUsers, $userData);
        }
        return $sanatizedUsers;
    }

}