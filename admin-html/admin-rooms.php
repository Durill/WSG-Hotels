<?php
include_once __DIR__ . '/../src/Mapper/RoomMapper.php';
include __DIR__ . '/admin-navbar.php';
if(!isset($_SESSION['adminIn'])){
    Header("Location: /admin-html/admin-login.php");
}

$roomMapper = new RoomMapper();

if(isset($_SESSION['status'])){
    if (strlen($_SESSION['status']) > 0){
        echo $_SESSION['status'];
        unset($_SESSION['status']);
    }
    }
    $rooms = $roomMapper->getRooms(); //TODO add rooms list
?>
<div class="container-md mt-5">
    <div class="d-flex flex-row-reverse">
        <a href="/admin-html/admin-add-room.php" class="btn btn-sm btn-primary">Dodaj pokój</a>
    </div>
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
                foreach($rooms as $room){
                    echo '<tr><th scope="row">'.$room->getId().'</th>
                            <td>'.$room->getPlaces().'</td>
                            <td>'.$room->getPrice().'</td>
                            <td>'.$room->getType().'</td>
                            <td>
                                <a href="/admin-html/admin-room-edit.php/?id='.$room->getId().'" class="btn btn-sm btn-warning me-1">Edytuj</a>
                                <a href="/admin-html/admin-room-delete.php/?id='.$room->getId().'" class="btn btn-sm btn-danger">Usuń</a>
                            </td></tr>';
                }
            ?>
  </tbody>
</table>
</div>
</body>
</html>