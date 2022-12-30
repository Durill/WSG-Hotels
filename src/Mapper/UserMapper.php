<?php

include_once __DIR__ . '/../StatusesEnum.php';
include_once __DIR__ . '/../Responses.php';
include_once __DIR__ . '/../DBConnect.php';

class UserMapper{
    
	private const DATABASE_HOST = 'localhost';
	private const DATABASE_USER = 'root';
	private const DATABASE_PASS = '';
	private const DATABASE_NAME = 'bsg-hotels';

    private const NAME_MIN_LENGTH = 3;
    private const NAME_MAX_LENGTH = 25;
    private const SURNAME_MIN_LENGTH = 3;
    private const SURNAME_MAX_LENGTH = 50;

    private $connection;
    private $responses;

    function __construct(){
        $this->responses = new Responses();
    }

    private function openDBConnection(){
        try{
            $dbConnect = new DBConnect();
            $this->connection = $dbConnect->makeDBConnection();
        }catch(Exception $e){
            echo $this->responses->userResponse(StatusesEnum::ERROR);
        }
    }

    private function save($name, $surname, $email, $password){
        $statement = $this->connection->prepare('INSERT INTO users (name, surname, email, password) VALUES (?, ?, ?, ?)');
        $pass = password_hash($password, PASSWORD_DEFAULT);
        $statement->bind_param('ssss', $name, $surname, $email, $pass);
        $statement->execute();
        $statement->close();
        if($this->connection->connect_errno){
            throw new Exception($this->responses->userResponse(StatusesEnum::ERROR));
        }
    }

    private function login($email, $password){
        $statement = $this->connection->prepare('SELECT name, password FROM users WHERE email = ?');
        $statement->bind_param('s', $email);
        $statement->execute();
        $statement->store_result();
        if ($statement->num_rows > 0) {
            $statement->bind_result($name, $serverPassword);
            $statement->fetch();
            if (password_verify($password, $serverPassword)) {
                session_start();
                $_SESSION['loggedIn'] = true;
                $_SESSION['name'] = $name;
                return $this->responses->userResponse(StatusesEnum::OK);
            } else {
                return $this->responses->userResponse(StatusesEnum::LOGIN_FAILED);
            }
        } else {
            return $this->responses->userResponse(StatusesEnum::LOGIN_FAILED);
        }
        
        $statement->close();
        if($this->connection->connect_errno){
            throw new Exception($this->responses->userResponse(StatusesEnum::ERROR));
        }
    }

    private function accountExists($email){
        if(strlen($email) > 0){
            $statement = $this->connection->prepare('SELECT id FROM users WHERE email = ?');
            $statement->bind_param('s', $email);
            $statement->execute();
            $statement->store_result();
            if($this->connection->connect_errno){
                throw new Exception($this->responses->userResponse(StatusesEnum::ERROR));
            }

            if($statement->num_rows > 0){
                $statement->close();
                return true;
            }else {
                $statement->close();
                return false;
            }
        } else{
            $statement->close();
            return false;
        }
    }

    private function validatePassword($password, $rePassword){
        if($password == $rePassword){
            if(strlen($password) >= 8){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    private function validateName($name){
        if(strlen($name) >= self::NAME_MIN_LENGTH && strlen($name) <= self::NAME_MAX_LENGTH){
            return true;
        }else{
            return false;
        }
    }

    private function validateSurname($surname){
        if((strlen($surname) >= self::SURNAME_MIN_LENGTH && strlen($surname) <= self::SURNAME_MAX_LENGTH)){
            return true;
        }else {
            return false;
        }
    }

    private function validateUserInput(User $user){
        $valid = false;
        if($this->validateName($user->getName())){
            $valid = true;
        }else{
            return false;
        }

        if($this->validateSurname($user->getSurname())){
            $valid = true;
        }else {
            return false;
        }

        if($this->validatePassword($user->getPassword(), $user->getRePassword())){
            $valid = true;
        }else {
            return false;
        }

        if(!$this->accountExists($user->getEmail())){
            $valid = true;
        }else{
            return false;
        }

        return $valid;
    }

	function registerUser(User $user){
        try{
            $this->openDBConnection();

            if($this->validateUserInput($user)) {
                    $this->save($user->getName(), $user->getSurname(), $user->getEmail(), $user->getPassword());
                    return $this->responses->userResponse(StatusesEnum::OK);
            }else {
                return $this->responses->userResponse(StatusesEnum::REGISTER_FAILED);
            }

            $this->connection->close();
        } catch(Exception $e){
            echo $this->responses->userResponse(StatusesEnum::ERROR);
        }
	}

    function loginUser($email, $password){
        try{
            $this->openDBConnection();

            if(strlen($email) > 0 && strlen($password) > 0 && $this->accountExists($email)){
                $this->login($email, $password);
                Header('Location: register.php');
                exit();
            }else{
                return $this->responses->userResponse(StatusesEnum::LOGIN_FAILED);
            }

            $this->connection->close();
        } catch(Exception $e){
            echo $this->responses->userResponse(StatusesEnum::ERROR);
        }
    }

    function logoutUser(){
        session_start();
        session_unset();
        session_destroy();
        header("Location:../html/register.php");
    }

}

?>