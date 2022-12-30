<?php

class Admin{

    private $id;
    private $username;
    private $email;
    private $password;

    function __construct($username, $password){
        $this->setUsername($username);
        $this->setPassword($password);
    }

    function getId(){
        return $this->id;
    }

    function getUsername(){
        return $this->username;
    }

    function setUsername($username){
        $this->username = $username;
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
}
?>