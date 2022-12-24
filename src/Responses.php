<?php
include_once __DIR__ . '/StatusesEnum.php';

    class Responses{

        function userResponse($status){
            switch($status){
                case StatusesEnum::OK:
                    return  '<div class="alert alert-success alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Rejestracja powiodła się! Teraz możesz się zalogować.
                            </div>';
                case StatusesEnum::FAILED:
                    return  '<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Podane dane są niepoprawne, sprawdź czy jest zgodne z naszymi zasadami:
                              <br>-Imię musi mieć minimum 3 znaki i maksimum 25
                              <br>-Nazwisko musi mieć minimum 3 znaki i maksimum 50
                              <br>-Hasła muszą być takie same
                              <br>-Hasło musi mieć minimum 8 znaków
                              <br>-Konto email nie może być już w użyciu
                            </div>';
                case StatusesEnum::ERROR:
                    return  '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Wystąpił niespodziewany błąd, spróbuj ponownie później.
                            </div>';
            }
        }
    }

?>