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
                            Podane dane są niepoprawne, sprawdź czy są zgodne z naszymi zasadami:
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
                            Podany adres email jest już w użyciu lub jest niepoprawny, wybierz inny i spróbuj ponownie.
                            </div>';
                case StatusesEnum::UPDATE_USER_PERSONAL_DATA_FAILED:
                    return  '<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Podane dane są niepoprawne, sprawdź czy są zgodne z naszymi zasadami:
                            <br>-Imię musi mieć minimum 3 znaki i maksimum 25
                            <br>-Nazwisko musi mieć minimum 3 znaki i maksimum 50
                            </div>';
                case StatusesEnum::UPDATE_USER_PASSWORD_FAILED:
                    return  '<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Podane dane są niepoprawne, sprawdź czy są zgodne z naszymi zasadami:
                            <br>-Hasła muszą być takie same
                            <br>-Hasło musi mieć minimum 8 znaków
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
                case StatusesEnum::ROOM_DELETE_FAILED:
                    return  '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Wystąpił błąd podczas usuwania pokoju.
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

        function reservationResponse($status){
            switch($status){
                case StatusesEnum::OK:
                    return  '<div class="alert alert-success alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Sukces, wszystko się powiodło!
                            </div>';
                case StatusesEnum::ROOMS_NOT_FOUND:
                    return  '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Nie znaleziono wolnych pokojów dla wybranych dat, spróbuj wybrać inne.
                            </div>';
                case StatusesEnum::DATES_NOT_VALID:
                    return  '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Wprowadzono niepoprawne dane. Upewnij się, że:
                            <br>-Data rozpoczęcia rezerwacji nie jest przed datą zakończenia
                            <br>-Data rozpoczęcia rezerwacji nie może być wcześniejsza niż data jutrzejsza
                            </div>';
                case StatusesEnum::ROOM_NOT_VALID:
                    return  '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Wprowadzono niepoprawne dane. Upewnij się, że wybrano prawidłowy pokój
                            </div>';
                case StatusesEnum::RESERVATIONS_NOT_FOUND:
                    return  '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Brak rezerwacji.
                            </div>';
                case StatusesEnum::RESERVATION_CANCEL_FAILED:
                    return  '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Nie możesz anulować tej rezerwacji
                            </div>';
            }
        }

        function CSRFResponse($status){
            switch($status){
                case StatusesEnum::CSRF_TOKEN_NOT_VALID:
                    return  '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Niepoprawny CSRF token!
                            <br>-Odśwież stronę i spróbuj ponownie.
                            </div>';
                }
        }
    }

?>