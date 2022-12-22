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
                            Rejestracja powiodła się! Teraz możesz się zalogować.
                            </div>';
                case Statuses::FAILED:
                    return  '<div class="alert alert-warning">
                            Konto o podanym adresie email już istnieje, proszę wybierz inny email!
                            </div>';
                case Statuses::ERROR:
                    return  '<div class="alert alert-danger">
                            Wystąpił niespodziewany błąd, spróbuj ponownie później.
                            </div>';
            }
        }
    }

?>