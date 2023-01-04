<?php

class StatusesEnum{
    // general
    const OK = "OK";
    const CREATE_FAILED = "CREATE_FAILED";
    const UPDATE_FAILED = "UPDATE_FAILED";
    // users
    const USER_NOT_FOUND = "USER_NOT_FOUND";
    const REGISTER_FAILED = "REGISTER_FAILED";
    const LOGIN_FAILED = "LOGIN_FAILED";
    const UPDATE_EMAIL_FAILED = "UPDATE_EMAIL_FAILED";
    // rooms
    const ROOM_NOT_FOUND = "ROOM_NOT_FOUND";
    const ROOMS_NOT_FOUND = "ROOMS_NOT_FOUND";
}

?>