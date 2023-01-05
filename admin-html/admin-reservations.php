<?php
include_once __DIR__ . '/../src/Validator.php';
include_once __DIR__ . '/../src/Mapper/ReservationMapper.php';
include __DIR__ . '/admin-navbar.php';
if(!isset($_SESSION['adminIn'])){
    Header("Location: /admin-html/admin-login.php");
}


$reservationMapper = new ReservationMapper();
$reservations = $reservationMapper->getReservationsForAdmin();

?>
<div class="container-fluid">
    <?php
        if(isset($_SESSION['status'])){
            if (strlen($_SESSION['status']) > 0){
                echo $_SESSION['status'];
                unset($_SESSION['status']);
            }
        }
    ?>
    <br>
  <h2 class="text-center">Rezerwacje</h2>
  <br>
  <table class="table table-hover table-light table-striped mt-2">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Użytkownik</th>
        <th scope="col">Od</th>
        <th scope="col">Do</th>
        <th scope="col">Ilość miejsc</th>
        <th scope="col">Cena</th>
        <th scope="col">Rodzaj</th>
        <th scope="col">Anulowana</th>
        <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
            <?php
                foreach($reservations as $reservation){
                    echo '<tr><th scope="row">'.$reservation['id'].'</th>
                            <td>'.$reservation['user'].'</td>
                            <td>'.$reservation['from_date'].'</td>
                            <td>'.$reservation['to_date'].'</td>
                            <td>'.$reservation['places'].'</td>
                            <td>'.$reservation['price'].'</td>
                            <td>'.ucfirst($reservation['room_type']).'</td>';
                    if ($reservation['canceled'] == 0) {
                        echo '<td>NIE</td><td>';
                    } else {
                        echo '<td>TAK</td><td>';
                    }
                    if (strtotime('+1 day') <= strtotime($reservation['from_date']) && $reservation['canceled'] == 0){
                        echo '<a href="/admin-html/cancel-reservation.php/?id='.$reservation['id'].'" class="btn btn-sm btn-danger me-1">Anuluj</a>';
                    }
                    echo '</td></tr>';
                }
            ?>
  </tbody>
</table>
</div>

<?php
include __DIR__."/template/footer.php";
?>