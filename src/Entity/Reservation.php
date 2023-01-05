<?php

class Reservation{

    private $id;
    private $room_id;
    private $user_id;
    private $price;
    private $places;
    private $room_type;
    private $from_date;
    private $to_date;
    private $canceled;

    function __construct($room_id, $user_id, $from_date, $to_date){
        $this->setRoomId($room_id);
        $this->setUserId($user_id);
        $this->setFromDate($from_date);
        $this->setToDate($to_date);
    }

    function getId(){
        return $this->id;
    }
    
    function setId($id){
        $this->id = $id;
    }

    function getRoomId(){
        return $this->room_id;
    }

    function setRoomId($room_id){
        $this->room_id = $room_id;
    }

    function getUserId(){
        return $this->user_id;
    }

    function setUserId($user_id){
        $this->user_id = $user_id;
    }

    function getPrice(){
        return $this->price;
    }

    function setPrice($price){
        $this->price = $price;
    }

    function getPlaces(){
        return $this->places;
    }

    function setPlaces($places){
        $this->places = $places;
    }

    function getRoomType(){
        return $this->room_type;
    }

    function setRoomType($room_type){
        $this->room_type = $room_type;
    }

    function getFromDate(){
        return $this->from_date;
    }

    function setFromDate($from_date){
        $this->from_date = $from_date;
    }

    function getToDate(){
        return $this->to_date;
    }

    function setToDate($to_date){
        $this->to_date = $to_date;
    }

    function getCanceled(){
        return $this->canceled;
    }

    function setCanceled($canceled){
        $this->canceled = $canceled;
    }
}
?>