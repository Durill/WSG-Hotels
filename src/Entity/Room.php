<?php

class Room{

    private $id;
    private $places;
    private $price;
    private $type;
    private $deleted;

    function __construct($places, $price, $type){
        $this->setPlaces($places);
        $this->setPrice($price);
        $this->setType($type);
    }

    function getId(){
        return $this->id;
    }
    
    function setId($id){
        $this->id = $id;
    }

    function getPlaces(){
        return $this->places;
    }

    function setPlaces($places){
        $this->places = $places;
    }

    function getPrice(){
        return $this->price;
    }

    function setPrice($price){
        $this->price = $price;
    }

    function getType(){
        return $this->type;
    }

    function setType($type){
        $this->type = $type;
    }

    function getDeleted(){
        return $this->deleted;
    }

    function setDeleted($deleted){
        $this->deleted = $deleted;
    }
}
?>