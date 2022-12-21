<?php

class UsersMapper{
    
	private const DATABASE_HOST = 'localhost';
	private const DATABASE_USER = 'root';
	private const DATABASE_PASS = '';
	private const DATABASE_NAME = 'bsg-hotels';

    private $connection;

    function __construct(){
    }

    private function openDBConnection(){
        try{
            $connection = mysqli_connect(self::DATABASE_HOST, self::DATABASE_USER, self::DATABASE_PASS, self::DATABASE_NAME);
            if(mysqli_connect_errno()){
                die ("Unable to connect to database: " . mysqli_error($connection));
            }
            return $connection;
        } catch(Exception $e){
            echo $e . mysqli_connect_error();
        }
    }

    private function save($name, $surname, $email, $password){
        try{
            $statement = $this->connection->prepare('INSERT INTO users (name, surname, email, password) VALUES (?, ?, ?, ?)');
            $pass = password_hash($password, PASSWORD_DEFAULT);
            $statement->bind_param('ssss', $name, $surname, $email, $pass);
            $statement->execute();
            $statement->close();
        } catch(Exception $e){
            echo $e;
        }
    }

    private function accountExists($email){
        try{
            $statement = $this->connection->prepare('SELECT id FROM users WHERE email = ?');
            $statement->bind_param('s', $email);
            $statement->execute();
            $statement->store_result();
            if($statement->num_rows > 0){
                $statement->close();
                return false;
            }else {
                $statement->close();
                return true;
            }
        } catch(Exception $e){
            echo $e . '  -  ' . $connection->error;
        }
    }

	function registerClient(Users $user){
        $this->connection = $this->openDBConnection();
        if (!$this->accountExists($user->getEmail())) {
                echo 'Account using this email already exists, please choose another!';
        } else {
                $this->save($user->getName(), $user->getSurname(), $user->getEmail(), $user->getPassword());
                echo 'You have successfully registered, you can now login!';
        }

		$this->connection->close();
	}

}

?>