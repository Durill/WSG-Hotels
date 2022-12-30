<?php
include_once __DIR__ . '/../StatusesEnum.php';
include_once __DIR__ . '/../Responses.php';
include_once __DIR__ . '/../DBConnect.php';

class AdminMapper{

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

    private function login($username, $password){
        $statement = $this->connection->prepare('SELECT password FROM admins WHERE username = ?');
        $statement->bind_param('s', $username);
        $statement->execute();
        $statement->store_result();
        if ($statement->num_rows > 0) {
            $statement->bind_result($serverPassword);
            $statement->fetch();
            if (password_verify($password, $serverPassword)) {
                session_start();
                $_SESSION['adminIn'] = true;
                $_SESSION['name'] = $username;
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

    function logoutAdmin(){
        session_start();
        session_unset();
        session_destroy();
        Header("Location:../admin-html/admin-login.php");
    }

    function loginAdmin(Admin $admin){
        try{
            $this->openDBConnection();

            if(strlen($admin->getUsername()) > 0 && strlen($admin->getPassword()) > 0){
                $this->login($admin->getUsername(), $admin->getPassword());
                Header('Location: admin-index.php');
                exit();
            }else{
                return $this->responses->userResponse(StatusesEnum::LOGIN_FAILED);
            }

            $this->connection->close();
        } catch(Exception $e){
            echo $this->responses->userResponse(StatusesEnum::ERROR);
        }
    }
}
?>