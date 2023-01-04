<?php

include_once __DIR__ . '/../StatusesEnum.php';
include_once __DIR__ . '/../Responses.php';
include_once __DIR__ . '/../DBConnect.php';
include_once __DIR__ . '/../Mapper/RoomMapper.php';
include_once __DIR__ . '/../Entity/Reservation.php';
include_once __DIR__ . '/../Entity/Room.php';


class ReservationMapper{

    private $connection;
    private $responses;
    private $roomMapper;

    function __construct(){
        $this->responses = new Responses();
        $this->roomMapper = new RoomMapper();
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
     * Create new reservation in database.
     * 
     * @param Reservation $reservation - Room class object.
     * @return boolean value of saving data process.
     */
    private function save(Reservation $reservation){
        $statement = $this->connection->prepare('INSERT INTO reservations (room_id, user_id, from_date, to_date) VALUES (?, ?, ?, ?)');
        $statement->bind_param('iiss', $reservation->getRoomId(), $reservation->getUserId(), $reservation->getFromDate(), $reservation->getToDate());
        $statement->execute();
        $statement->close();
        return true;
    }

    /**
     * Validating user or room id for reservation.
     * 
     * @param int $id - room or user id.
     * @return boolean value of validating process.
     */
    private function isIdValid($id){
        if(is_numeric($id) && $id > 0){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Validating reservation dates.
     * 
     * @param string $from_date - reservation to_date.
     * @param string $to_date - reservation from_date.
     * @return boolean value of validating process.
     */
    private function areDatesValid($from_date, $to_date){
        if ((bool)strtotime($from_date) &&
            (bool)strtotime($to_date) &&
            strtotime($from_date) <= strtotime($to_date) &&
            strtotime($from_date) > strtotime('now')
            ){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Validating provided reservation data.
     * 
     * @param Reservation $reservation - Reservation class object.
     * @return boolean value of validating process.
     */
    private function isReservationInputValid(Reservation $reservation){
        return (
            $this->isIdValid($reservation->getRoomId()) &&
            $this->isIdValid($reservation->getUserId()) &&
            $this->areDatesValid($reservation->getFromDate(), $reservation->getToDate())
        );
    }

    /**
     * Get available rooms based on date ranges.
     * 
     * @param string $from_date - reservation to_date.
     * @param string $to_date - reservation from_date.
     * @return array $rooms - array of Room objects.
     */
    private function getAvailableRooms($from_date, $to_date){
        try{
            $this->openDBConnection();

            $statement = 'SELECT id FROM rooms WHERE id NOT IN (SELECT room_id FROM reservations WHERE ';
            $statement .= '((?) BETWEEN from_date AND to_date) OR ((?) BETWEEN from_date AND to_date))';
            $statement = $this->connection->prepare($statement);
            $statement->bind_param('ss', $from_date, $to_date);
            $room_ids = array();
            $statement->execute();
            $statement->store_result();
            if ($statement->num_rows > 0){
                $statement->bind_result($id);
                while ($statement->fetch()) {
                    array_push($room_ids, $id);
                }
            }

            $rooms = $this->roomMapper->getRoomsByIds($room_ids);

            $this->connection->close();
            return $rooms;
        } catch(Exception $e){
            Header('Location: /html/errorPage.php');
            exit();
        }
    }

    /**
     * Checking reservation data and saving it if valid.
     * 
     * @param Reservation $reservation - Reservation class object.
     * @return status of process.
     */
	function createReservation(Reservation $reservation){
        try{
            $this->openDBConnection();

            if($this->isReservationInputValid($reservation)) {
                    if($this->save($reservation)){
                        $_SESSION['status'] = $this->responses->reservationResponse(StatusesEnum::OK);
                        unset($_SESSION['available_rooms']);
                        unset($_SESSION['from_date']);
                        unset($_SESSION['to_date']);
                        Header('Location: /html/myReservations.php');
                        exit();
                    }
            }else {
                $_SESSION['status'] = $this->responses->reservationResponse(StatusesEnum::CREATE_FAILED);
            }
            $this->connection->close();
        } catch(Exception $e){
            Header('Location: /html/errorPage.php');
            exit();
        }
	}

    /**
     * Select reservation dates and redirect to second step of reservation.
     * 
     * @param string $from_date - reservation to_date.
     * @param string $to_date - reservation from_date.
     * @return status of process.
     */

	function selectReservationDates($from_date, $to_date){
        try{
            if (!$this->areDatesValid($from_date, $to_date)){
                $_SESSION['status'] = $this->responses->reservationResponse(StatusesEnum::DATES_NOT_VALID);
                Header('Location: /html/createReservation.php');
                exit();
            }
            $rooms = $this->getAvailableRooms($from_date, $to_date);
            if ($rooms){
                $_SESSION['available_rooms'] = serialize($rooms);
                $_SESSION['from_date'] = $from_date;
                $_SESSION['to_date'] = $to_date;
                Header('Location: /html/createReservationSecondStep.php');
            } else {
                $_SESSION['status'] = $this->responses->roomResponse(StatusesEnum::ROOMS_NOT_FOUND);
                Header('Location: /html/createReservation.php');
            exit();
            }
        } catch(Exception $e){
            Header('Location: /html/errorPage.php');
            exit();
        }
	}

}

?>