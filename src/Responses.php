<?php
include_once __DIR__ . '/StatusesEnum.php';

    class Responses{

        function userResponse($status){
            switch($status){
                case StatusesEnum::OK:
                    return  '<div class="alert alert-success alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Sukces, wszystko się powiodło!
                            </div>';
                case StatusesEnum::USER_NOT_FOUND:
                    return  '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Wystąpił niespodziewany błąd, spróbuj ponownie później.
                            </div>';
                case StatusesEnum::REGISTER_FAILED:
                    return  '<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Podane dane są niepoprawne, sprawdź czy jest zgodne z naszymi zasadami:
                            <br>-Imię musi mieć minimum 3 znaki i maksimum 25
                            <br>-Nazwisko musi mieć minimum 3 znaki i maksimum 50
                            <br>-Hasła muszą być takie same
                            <br>-Hasło musi mieć minimum 8 znaków
                            <br>-Konto email nie może być już w użyciu
                            </div>';
                case StatusesEnum::LOGIN_FAILED:
                    return  '<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Email lub hasło jest nieprawidłowe.
                            </div>';
                case StatusesEnum::UPDATE_EMAIL_FAILED:
                    return  '<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Podany adres email jest już w użyciu, wybierz inny i spróbuj ponownie.
                            </div>';
            }
        }

        function roomResponse($status){
            switch($status){
                case StatusesEnum::OK:
                    return  '<div class="alert alert-success alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Sukces, wszystko się powiodło!
                            </div>';
                case StatusesEnum::CREATE_FAILED:
                    return  '<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Podane dane są niepoprawne, sprawdź czy jest zgodne z naszymi zasadami:
                            <br>-Ilość miejsc w pokoju jest większa lub równa 1 i mniejsza lub równa 10
                            <br>-Cena jest większa niż 1 i mniejsza niż 100 mln
                            <br>-Rodzaj pokoju został wybrany
                            </div>';
                case StatusesEnum::UPDATE_FAILED:
                    return  '<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Podane dane są niepoprawne, sprawdź czy jest zgodne z naszymi zasadami:
                            <br>-Ilość miejsc w pokoju jest większa lub równa 1 i mniejsza lub równa 10
                            <br>-Cena jest większa niż 1 i mniejsza niż 100 mln
                            <br>-Rodzaj pokoju został wybrany
                            </div>';
                case StatusesEnum::ROOM_NOT_FOUND:
                    return  '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Nie znaleziono takiego pokoju.
                            </div>';
                case StatusesEnum::ROOMS_NOT_FOUND:
                    return  '<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Nie znaleziono pokojów.
                            </div>';
            }
        }
    }

?>