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

    /**
     * Opening connection with DataBase
     */
    private function openDBConnection(){
        try{
            $dbConnect = new DBConnect();
            $this->connection = $dbConnect->makeDBConnection();
        }catch(Exception $e){
            Header('Location: /html/errorPage.php');
            exit();
        }
    }

    /**
     * Starting session if admin is validated.
     * 
     * @param string $username - admin username.
     * @param string $password - admin password.
     * @return boolean value of logging in process.
     */
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
     * Destroying and unsetting admin session.
     */
    function logoutAdmin(){
        session_start();
        session_unset();
        session_destroy();
        Header("Location:../admin-html/admin-login.php");
    }

    /**
     * Checking admin credentials and logging in if valid.
     * 
     * @param Admin $admin - Admin class object.
     * @return status of process.
     */
    function loginAdmin(Admin $admin){
        try{
            $this->openDBConnection();

            if(strlen($admin->getUsername()) > 0 && strlen($admin->getPassword()) > 0){
                if($this->login($admin->getUsername(), $admin->getPassword())){
                    $_SESSION['adminStatus'] = $this->responses->userResponse(StatusesEnum::OK);
                    Header('Location: /admin-html/admin-reservations.php');
                    exit();
                }else{
                    $_SESSION['adminStatus'] = $this->responses->userResponse(StatusesEnum::LOGIN_FAILED);
                }
            }else{
                $_SESSION['adminStatus'] = $this->responses->userResponse(StatusesEnum::LOGIN_FAILED);
            }
            $this->connection->close();
        } catch(Exception $e){
            Header('Location: /html/errorPage.php');
            exit();
        }
    }
}
?>