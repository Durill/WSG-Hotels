<?php

class User{

    private $id;
    private $name;
    private $surname;
    private $email;
    private $password;
    private $rePassword;
    private $acc_activated;

    function __construct($name, $surname, $email, $password, $rePassword){
        $this->setName($name);
        $this->setSurname($surname);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setRePassword($rePassword);
        $this->setAccActivated(false);
    }

    function getId(){
        return $this->id;
    }

    function setId($id){
        $this->id = $id;
    }

    function getName(){
        return $this->name;
    }

    function setName($name){
        $this->name = $name;
    }

    function getSurname(){
        return $this->surname;
    }

    function setSurname($surname){
        $this->surname = $surname;
    }

    function getEmail(){
        return $this->email;
    }

    function setEmail($email){
        $this->email = $email;
    }

    function getPassword(){
        return $this->password;
    }

    function setPassword($password){
        $this->password = $password;
    }

    function getRePassword(){
        return $this->rePassword;
    }

    function setRePassword($rePassword){
        $this->rePassword = $rePassword;
    }

    function getAccActivated(){
        return $this->acc_activated;
    }

    function setAccActivated($acc_activated){
        $this->acc_activated = $acc_activated;
    }
}

?>