<?php

include_once __DIR__ . '/StatusesEnum.php';
include_once __DIR__ . '/Responses.php';

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
        mysqli_report(MYSQLI_REPORT_ERROR|MYSQLI_REPORT_STRICT);
        error_reporting(E_ERROR | E_PARSE);
        $con = new mysqli(self::DATABASE_HOST, self::DATABASE_USER, self::DATABASE_PASS, self::DATABASE_NAME);
        if($con->connect_errno){
            throw new Exception($this->responses->userResponse(StatusesEnum::ERROR));
        }
        $this->connection = $con;
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

    private function validateUserInput(User $user){
        $valid = false;
        if(strlen($user->getName()) >= self::NAME_MIN_LENGTH && strlen($user->getName()) <= self::NAME_MAX_LENGTH){
            $valid = true;
        }else{
            return false;
        }

        if((strlen($user->getSurname()) >= self::SURNAME_MIN_LENGTH && strlen($user->getSurname()) <= self::SURNAME_MAX_LENGTH)){
            $valid = true;
        }else {
            return false;
        }

        if($user->getPassword() == $user->getRePassword()){
            if(strlen($user->getPassword()) >= 8){
                $valid = true;
            }else{
                return false;
            }
        }else{
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
                return $this->responses->userResponse(StatusesEnum::FAILED);
            }

            $this->connection->close();
        } catch(Exception $e){
            echo $this->responses->userResponse(StatusesEnum::ERROR);
        }
	}

    function loginUser($email, $password){
        try{
            if(strlen($email) > 0 && strlen($password) > 0){
                $this->login($email, $password);
                header('Location: index.html');
            }else{
                return $this->responses->userResponse(StatusesEnum::LOGIN_FAILED);
            }
        } catch(Exception $e){
            echo $this->responses->userResponse(StatusesEnum::ERROR);
        }
    }

}

?>