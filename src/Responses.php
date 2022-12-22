<?php
include_once __DIR__ . '/Statuses.php';

    class Responses{

        private $statuses;

        function __construct(){
            $statuses = new Statuses();
        }

        function userResponse($status){
            switch($status){
                case Statuses::OK:
                    return  '<div class="alert alert-success">
                            You have successfully registered, you can now login!
                            </div>';
                case Statuses::FAILED:
                    return  '<div class="alert alert-warning">
                            Account using this email already exists, please choose another!
                            </div>';
                case Statuses::ERROR:
                    return  '<div class="alert alert-danger">
                            An unexpected error occurred, try again later
                            </div>';
            }
        }
    }

?>