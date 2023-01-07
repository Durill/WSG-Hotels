<?php
include_once __DIR__ . '/Responses.php';
include_once __DIR__ . '/Validator.php';


class CSRFToken{
    private const EXPIRATION_TIME = 60 * 15; // 15min
    private $validator;

    function __construct(){
        $this->validator = new Validator();
    }

    private function getToken(){
        if (
            !isset($_SESSION['csrf_token']) ||
            !isset($_SESSION['csrf_time']) ||
            $_SESSION['csrf_time'] + self::EXPIRATION_TIME < time()
            ) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                $_SESSION['csrf_time'] = time();
        }
        return $_SESSION['csrf_token'];
    }

    private function getNewToken(){
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_time'] = time();
    }
    
    function getTokenInput(){
        $token = hash_hmac('sha256', htmlspecialchars($_SERVER['PHP_SELF']), $this->getToken());
        return '<input type="hidden" name="csrf_token" value="'.$token.'">';
    }

    function verifyToken($input_token){
        $calc = hash_hmac('sha256', htmlspecialchars($_SERVER['PHP_SELF']), $this->getToken());
        if (hash_equals($calc, $this->validator->test_input($input_token))){
            return true;
        } else {
            $this->getNewToken();
            $responses = new Responses();
            $_SESSION['status'] = $responses->CSRFResponse(StatusesEnum::CSRF_TOKEN_NOT_VALID);
            return false;
        }
    }
}

?>