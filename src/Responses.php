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
                    return  nl2br('<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Podane dane są niepoprawne, sprawdź czy jest zgodne z naszymi zasadami:
                              -Imię musi mieć minimum 3 znaki i maksimum 25
                              -Nazwisko musi mieć minimum 3 znaki i maksimum 50
                              -Hasła muszą być takie same
                              -Konto email nie może być już w użyciu
                            </div>');
                case StatusesEnum::ERROR:
                    return  '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Wystąpił niespodziewany błąd, spróbuj ponownie później.
                            </div>';
            }
        }
    }

?>