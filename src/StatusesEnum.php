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
    const ROOM_DELETE_FAILED = "ROOM_DELETE_FAILED";
    // reservations
    const DATES_NOT_VALID = "ROOM_DELETE_FAILED";
    const ROOM_NOT_VALID = "ROOM_NOT_VALID";
    const RESERVATIONS_NOT_FOUND = "RESERVATIONS_NOT_FOUND";
}

?>