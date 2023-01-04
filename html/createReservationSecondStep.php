<?php
include __DIR__ . '/template/navbar.php';
include_once __DIR__ . '/../src/Responses.php';
include_once __DIR__ . '/../src/Validator.php';
include_once __DIR__ . '/../src/Mapper/ReservationMapper.php';
include_once __DIR__ . '/../src/Entity/Reservation.php';

if(!isset($_SESSION['loggedIn'])){
    Header("Location: /html/login.php");
    exit();
}

if(!(isset($_SESSION['available_rooms']) && isset($_SESSION['from_date']) && isset($_SESSION['to_date']))){
    Header("Location: /html/createReservation.php");
    exit();
}

$_SESSION['second_step'] = 1;
$available_rooms = unserialize($_SESSION['available_rooms']);
$validator = new Validator;
$reservationMapper = new ReservationMapper();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['room_id'])) {
    $id = $validator->test_input($_POST['room_id']);
    if (in_array($id, $available_rooms)) {
        $reservation = new Reservation($_POST['room_id'], $_SESSION['id'], $_SESSION['from_date'], $_SESSION['to_date']);
        $available_rooms = $reservationMapper->createReservation($reservation);
    } else {
        $responses = new Responses();
        $_SESSION['status'] = $responses->reservationResponse(StatusesEnum::ROOM_NOT_VALID);
    }
}

?>

<div class="container-fluid userData">
    <?php
      if(isset($_SESSION['status'])){
        if (strlen($_SESSION['status']) > 0){
           echo $_SESSION['status'];
           unset($_SESSION['status']);
        }
     }
    ?>
    <br>
    <h2>Zarezerwuj pokój</h2>
    <br>
    <table class="table table-hover table-light table-striped mt-2">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Ilość miejsc</th>
                <th scope="col">Cena</th>
                <th scope="col">Rodzaj</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($available_rooms as $room){
                echo '<tr><th scope="row">'.$room->getId().'</th>
                        <td>'.$room->getPlaces().'</td>
                        <td>'.$room->getPrice().'</td>
                        <td>'.ucfirst($room->getType()).'</td>
                        <td>
                            <form action="" method="POST">
                                <input type="hidden" value="'.$room->getId().'" name="room_id"></input>
                                <input type="submit" value="Zarezerwuj" class="btn btn-sm btn-success"></input>
                            </form>
                        </td></tr>';
            }
        ?>
        </tbody>
    </table>
</div>
<?php
include __DIR__."/template/footer.php";
?>