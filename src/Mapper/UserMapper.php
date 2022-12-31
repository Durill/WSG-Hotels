<?php

include_once __DIR__ . '/../StatusesEnum.php';
include_once __DIR__ . '/../Responses.php';
include_once __DIR__ . '/../DBConnect.php';

class UserMapper{

    private const NAME_MIN_LENGTH = 3;
    private const NAME_MAX_LENGTH = 25;
    private const SURNAME_MIN_LENGTH = 3;
    private const SURNAME_MAX_LENGTH = 50;

    private $connection;
    private $responses;

    function __construct(){
        $this->responses = new Responses();
    }

    /**
     * Opening connection with DataBase
     */
    private function openDBConnection(){
        try{
            $dbConnect = new DBConnect();
            $this->connection = $dbConnect->makeDBConnection();
        }catch(Exception $e){
            Header('Location: errorPage.php');
            exit();
        }
    }

                
    /**
     * Sending new user data to DataBase.
     * 
     * @param User $user - User class object.
     * @return boolean value of saving data process.
     */
    private function save(User $user){
        $statement = $this->connection->prepare('INSERT INTO users (name, surname, email, password) VALUES (?, ?, ?, ?)');
        $pass = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $statement->bind_param('ssss', $user->getName(), $user->getSurname(), $user->getEmail(), $pass);
        $statement->execute();
        $statement->close();
        return true;
    }

                
    /**
     * Starting session if user is validated.
     * 
     * @param string $email - user email adress.
     * @param string $password - user password.
     * @return boolean value of logging in process.
     */
    private function login($email, $password){
        $statement = $this->connection->prepare('SELECT id, password FROM users WHERE email = ?');
        $statement->bind_param('s', $email);
        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows > 0) {
            $statement->bind_result($id, $serverPassword);
            $statement->fetch();
            if (password_verify($password, $serverPassword)) {
                session_start();
                $_SESSION['loggedIn'] = true;
                $_SESSION['id'] = $id;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }  
        $statement->close();
    }

                
    /**
     * Checking if provided email exist.
     * 
     * @param string $email - user email adress.
     * @return boolean value of validating process.
     */
    private function accountExist($email){
        try{
            if(strlen($email) > 0){
                $statement = $this->connection->prepare('SELECT id FROM users WHERE email = ?');
                $statement->bind_param('s', $email);
                $statement->execute();
                $statement->store_result();
                if($statement->num_rows > 0){
                    return true;
                }else {
                    return false;
                }
                $statement->close();
            } else{
                return false;
            }
        } catch (Exception $e){
            Header('Location: errorPage.php');
            exit();
        }
    }

            
    /**
     * Validating user password.
     * 
     * @param string $password - user password.
     * @param string $rePassword - user repeated password.
     * @return boolean value of validating process.
     */
    private function isPasswordValid($password, $rePassword){
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

            
    /**
     * Validating user name.
     * 
     * @param string $name - user name.
     * @return boolean value of validating process.
     */
    private function isNameValid($name){
        if(strlen($name) >= self::NAME_MIN_LENGTH && strlen($name) <= self::NAME_MAX_LENGTH){
            return true;
        }else{
            return false;
        }
    }

        
    /**
     * Validating user surname.
     * 
     * @param string $surname - user surname.
     * @return boolean value of validating process.
     */
    private function isSurnameValid($surname){
        if((strlen($surname) >= self::SURNAME_MIN_LENGTH && strlen($surname) <= self::SURNAME_MAX_LENGTH)){
            return true;
        }else {
            return false;
        }
    }

    
    /**
     * Validating provided user data.
     * 
     * @param User $user - User class object.
     * @return boolean value of validating process.
     */
    private function isUserInputValid(User $user){
        $valid = false;
        if($this->isNameValid($user->getName())){
            $valid = true;
        }else{
            return false;
        }

        if($this->isSurnameValid($user->getSurname())){
            $valid = true;
        }else {
            return false;
        }

        if($this->isPasswordValid($user->getPassword(), $user->getRePassword())){
            $valid = true;
        }else {
            return false;
        }

        if(!$this->accountExist($user->getEmail())){
            $valid = true;
        }else{
            return false;
        }

        return $valid;
    }

    /**
     * Checking register data and register if valid.
     * 
     * @param User $user - User class object.
     * @return status of process.
     */
	function registerUser(User $user){
        try{
            $this->openDBConnection();

            if($this->isUserInputValid($user)) {
                    if($this->save($user)){
                        $_SESSION['status'] = $this->responses->userResponse(StatusesEnum::OK);
                        Header('Location: login.php');
                        exit();
                    }
            }else {
                $_SESSION['status'] = $this->responses->userResponse(StatusesEnum::REGISTER_FAILED);
            }
            $this->connection->close();
        } catch(Exception $e){
            Header('Location: errorPage.php');
            exit();
        }
	}

    /**
     * Checking user credentials and logging in if valid.
     * 
     * @param string $email - user email adress.
     * @param string $password - user password.
     * @return status of process.
     */
    function loginUser($email, $password){
        try{
            $this->openDBConnection();
            if(strlen($email) > 0 && strlen($password) > 0 && $this->accountExist($email)){
                if($this->login($email, $password)){
                    $_SESSION['status'] = $this->responses->userResponse(StatusesEnum::OK);
                    Header('Location: myData.php');
                    exit();
                }else{
                    $_SESSION['status'] = $this->responses->userResponse(StatusesEnum::LOGIN_FAILED);
                }
            }else {
                $_SESSION['status'] = $this->responses->userResponse(StatusesEnum::LOGIN_FAILED);
            }
            $this->connection->close();
        } catch(Exception $e){
            Header('Location: errorPage.php');
            exit();
        }
    }

    /**
     * Destroying and unsetting user session.
     */
    function logoutUser(){
        session_start();
        session_unset();
        session_destroy();
        header("Location:../html/login.php");
    }

    /**
     * Provide user personal data using id.
     * 
     * @param integer $id - id of user.
     * @return User $user - User class object.
     */
    function getUserData($id){
        try{
            $this->openDBConnection();

            $statement = $this->connection->prepare('SELECT name, surname, email FROM users WHERE id = ?');
            $statement->bind_param('i', $id);
            $statement->execute();
            $statement->store_result();

            if ($statement->num_rows > 0) {
                $statement->bind_result($name, $surname, $email);
                $statement->fetch();

                $user = new User();
                $user->setName($name);
                $user->setSurname($surname);
                $user->setEmail($email);

                $statement->close();
                return $user;
            }else{
                $_SESSION['status'] = $this->responses->userResponse(StatusesEnum::USER_NOT_FOUND);
            }
            $statement->close();
            $this->connection->close();
        } catch(Exception $e){
            Header('Location: errorPage.php');
            exit();
        }

    }

    /**
     * Updating user personal data.
     * 
     * @param User $user - User class object.
     * @return status of process.
     */
    function updateUserData(User $user){
        try{
            $this->openDBConnection();

            $statement = $this->connection->prepare('UPDATE users SET name = ?, surname = ? WHERE id = ?');
            $statement->bind_param('ssi',$user->getName(), $user->getSurname(), $user->getId());
            $statement->execute();
            $statement->close();
            $_SESSION['status'] =  $this->responses->userResponse(StatusesEnum::OK);
            $this->connection->close();
        } catch(Exception $e){
            Header('Location: errorPage.php');
            exit();
        }
    }

    /**
     * Updating user email adress.
     * 
     * @param integer $id - id of user.
     * @param string $email - user email adress.
     * @return status of process.
     */
    function updateUserEmail($id, $email){
        try{
            $this->openDBConnection();

            if(!$this->accountExist($email)){
                $statement = $this->connection->prepare('UPDATE users SET email = ? WHERE id = ?');
                $statement->bind_param('si',$email,  $id);
                $statement->execute();
                $statement->close();
                $_SESSION['status'] =  $this->responses->userResponse(StatusesEnum::OK);
            } else{
                $_SESSION['status'] =  $this->responses->userResponse(StatusesEnum::UPDATE_EMAIL_FAILED);
            }
            $this->connection->close();
        } catch(Exception $e){
            Header('Location: errorPage.php');
            exit();
        }
    }

    /**
     * Updating user password.
     * 
     * @param integer $id - id of user.
     * @param array $passwords - array of passwords in order (oldPassword, newPassword, newRePassword).
     * @return status of process.
     */
    function updateUserPassword($id, $passwords){
        try{
            if($this->isPasswordValid($passwords[1], $passwords[2])){
                $this->openDBConnection();

                $statement = $this->connection->prepare('SELECT password FROM users WHERE id = ?');
                $statement->bind_param('i', $id);
                $statement->execute();
                $statement->store_result();
                if ($statement->num_rows > 0) {
                    $statement->bind_result($serverPassword);
                    $statement->fetch();
                    if (password_verify($passwords[0], $serverPassword)) {
                        $statement = $this->connection->prepare('UPDATE users SET password = ? WHERE id = ?');
                        $statement->bind_param('si', password_hash($passwords[1], PASSWORD_DEFAULT), $id);
                        $statement->execute();
                        $statement->close();
                        $_SESSION['status'] =  $this->responses->userResponse(StatusesEnum::OK);
                    } else {
                        $_SESSION['status'] =  $this->responses->userResponse(StatusesEnum::LOGIN_FAILED);
                    }
                } else {
                    $_SESSION['status'] =  $this->responses->userResponse(StatusesEnum::LOGIN_FAILED);
                }
                $statement->close();
                $this->connection->close();
            }
        } catch(Exception $e){
            Header('Location: errorPage.php');
            exit();
        }
    }

}

?>