<?php
include_once __DIR__ . '/StatusesEnum.php';
include_once __DIR__ . '/Responses.php';

class DBConnect{

    private $config;
    private $responses;

    function __construct(){
        $this->config = parse_ini_file('../../private/config.ini');
        $this->responses = new Responses();
    }

    function makeDBConnection(){
        try{
            mysqli_report(MYSQLI_REPORT_ERROR|MYSQLI_REPORT_STRICT);
            error_reporting(E_ERROR | E_PARSE);
            $connection = new mysqli($this->config['servername'], $this->config['username'], $this->config['password'], $this->config['dbname']);
            if($connection->connect_errno){
                throw new Exception($this->responses->userResponse(StatusesEnum::ERROR));
            }
            return $connection;
        } catch(Exception $e){
            echo $e;
        }
    }
}
?>