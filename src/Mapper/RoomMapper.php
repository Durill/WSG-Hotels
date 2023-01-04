<?php

include_once __DIR__ . '/../StatusesEnum.php';
include_once __DIR__ . '/../Responses.php';
include_once __DIR__ . '/../DBConnect.php';
include_once __DIR__ . '/../Entity/Room.php';

enum RoomType: string{
    case BRONZE = 'bronze';
    case SILVER = 'silver';
    case GOLD = 'gold';
}

class RoomMapper{

    private const PLACES_MIN_SIZE = 1;
    private const PLACES_MAX_SIZE = 10;
    private const PRICE_MIN_VALUE = 1;
    private const PRICE_MAX_VALUE = 10**8;

    private $connection;
    private $responses;

    function __construct(){
        $this->responses = new Responses();
    }

    /**
     * Opening connection with DataBase
     */
    private function openDBConnection(){
        try{
            $dbConnect = new DBConnect();
            $this->connection = $dbConnect->makeDBConnection();
        }catch(Exception $e){
            Header('Location: /html/errorPage.php');
            exit();
        }
    }


    /**
     * Create new room in database.
     * 
     * @param Room $room - Room class object.
     * @return boolean value of saving data process.
     */
    private function save(Room $room){
        $statement = $this->connection->prepare('INSERT INTO rooms (places, price, room_type) VALUES (?, ?, ?)');
        $statement->bind_param('ids', $room->getPlaces(), $room->getPrice(), $room->getType());
        $statement->execute();
        $statement->close();
        return true;
    }

    /**
     * Update existing room in database.
     * 
     * @param Room $room - Room class object.
     * @return boolean value of saving data process.
     */
    private function update(Room $room){
        $statement = 'UPDATE rooms SET ';
        $statement .= 'places = (?), price = (?), room_type = (?) ';
        $statement .= 'WHERE id = (?)';
        $statement = $this->connection->prepare($statement);
        $statement->bind_param('idsi', $room->getPlaces(), $room->getPrice(), $room->getType(), $room->getId());
        $statement->execute();
        $statement->close();
        return true;
    }

    /**
     * Provide room data using id.
     * 
     * @param integer $id - id of room.
     * @return Room $room - Room class object.
     */
    function getRoom($id){
        try{
            $this->openDBConnection();

            $statement = $this->connection->prepare('SELECT places, price, room_type FROM rooms WHERE id = (?)');
            $statement->bind_param('i', $id);
            $statement->execute();
            $statement->store_result();

            if ($statement->num_rows > 0) {
                $statement->bind_result($places, $price, $room_type);
                $statement->fetch();

                $room = new Room($places, $price, $type);;
                $room->setId($id);

                $statement->close();
                return $room;
            }else{
                $_SESSION['status'] = $this->responses->roomResponse(StatusesEnum::ROOM_NOT_FOUND);
            }
            $statement->close();
            $this->connection->close();
        } catch(Exception $e){
            Header('Location: /html/errorPage.php');
            exit();
        }

    }

    /**
     * Provide all rooms.
     * 
     * @return array of Room class objects.
     */
    function getRooms(){
        try{
            $this->openDBConnection();

            $statement = $this->connection->prepare('SELECT id, places, price, room_type FROM rooms');
            $rooms = array();
            $statement->execute();
            $statement->store_result();
            if ($statement->num_rows > 0){
                $statement->bind_result($id, $places, $price, $room_type);
                while ($statement->fetch()) {
                    $room = new Room($places, $price, $room_type);
                    $room->setId($id);
    
                    array_push($rooms, $room);
                }
            }else {
                $_SESSION['status'] = $this->responses->roomResponse(StatusesEnum::ROOMS_NOT_FOUND);
            }

            $this->connection->close();
            return $rooms;
        } catch(Exception $e){
            Header('Location: /html/errorPage.php');
            exit();
        }
    }

    /**
     * Checking if room exists.
     * 
     * @param int $id - room id.
     * @return boolean value of validating process.
     */
    private function roomExists($id){
        try{
            if(is_numeric($id) && $id > 0){
                $statement = $this->connection->prepare('SELECT TOP 1 1 FROM rooms WHERE id = (?)');
                $statement->bind_param('i', $id);
                $statement->execute();
                $statement->store_result();
                return ($statement->num_rows > 0);
            } else{
                return false;
            }
        } catch (Exception $e){
            Header('Location: /html/errorPage.php');
            exit();
        }
    }

    /**
     * Validating room places.
     * 
     * @param int $places - room places.
     * @return boolean value of validating process.
     */
    private function isPlacesValid($places){
        return (
            is_numeric($places) &&
            $places >= self::PLACES_MIN_SIZE &&
            $places <= self::PLACES_MAX_SIZE
        );
    }

    /**
     * Validating room price.
     * 
     * @param float $price - room price.
     * @return boolean value of validating process.
     */
    private function isPriceValid($price){
        return (
            is_numeric($price) &&
            $price >= self::PRICE_MIN_VALUE &&
            $price <= self::PRICE_MAX_VALUE
        );
    }

    /**
     * Validating room type.
     * 
     * @param int $type - user type.
     * @return boolean value of validating process.
     */
    private function isTypeValid($type){
        if(RoomType::tryFrom($type) != null){
            return true;
        }else{
            return false;
        };
    }

    /**
     * Validating provided room data.
     * 
     * @param Room $room - Room class object.
     * @return boolean value of validating process.
     */
    private function isRoomInputValid(Room $room){
        return (
            $this->isPlacesValid($room->getPlaces()) &&
            $this->isPriceValid($room->getPrice()) &&
            $this->isTypeValid($room->getType())
        );
    }

    /**
     * Checking room data and saving room if valid.
     * 
     * @param Room $room - Room class object.
     * @return status of process.
     */
	function createRoom(Room $room){
        try{
            $this->openDBConnection();

            if($this->isRoomInputValid($room)) {
                    if($this->save($room)){
                        $_SESSION['status'] = $this->responses->roomResponse(StatusesEnum::OK);
                        Header('Location: /admin-html/admin-rooms.php');
                        exit();
                    }
            }else {
                $_SESSION['status'] = $this->responses->roomResponse(StatusesEnum::CREATE_FAILED);
            }
            $this->connection->close();
        } catch(Exception $e){
            Header('Location: /html/errorPage.php');
            exit();
        }
	}

    /**
     * Checking room data and updating room if valid.
     * 
     * @param Room $room - Room class object.
     * @return status of process.
     */
	function updateRoom(Room $room){
        try{
            $this->openDBConnection();

            if($this->isRoomInputValid($room) && $this->roomExists($room->getId())) {
                    if($this->update($room)){
                        $_SESSION['status'] = $this->responses->roomResponse(StatusesEnum::OK);
                        Header('Location: /admin-html/admin-rooms.php');
                        exit();
                    }
            }else {
                $_SESSION['status'] = $this->responses->roomResponse(StatusesEnum::UPDATE_FAILED);
            }
            $this->connection->close();
        } catch(Exception $e){
            Header('Location: /html/errorPage.php');
            exit();
        }
	}

}

?>