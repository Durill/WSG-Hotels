<?php
include __DIR__ . '/template/navbar.php';
include_once __DIR__ . '/../src/Validator.php';
include_once __DIR__ . '/../src/Mapper/ReservationMapper.php';

if(!isset($_SESSION['loggedIn'])){
    Header("Location: /html/login.php");
    exit();
}

$reservationMapper = new ReservationMapper();
$validator = new Validator();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = '';

    if (isset($_POST['id'])) {
      $id = $validator->test_input($_POST["id"]);
    }

    $reservationMapper->cancelReservation($id, $_SESSION['id']);
}

$id = "";
if (isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];
} else {
    Header("Location: /html/errorPage.php");
}

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
  <h2 class="text-center" >Anuluje rezerwację</h2>
  <br>
  <form action="" method="POST" class="border rounded-1 border-dark p-2 container-md my-5">
        <p>Czy na pewno chcesz anulować tą rezerwacje?</p>
        <p>ID rezerwacji: <?php echo $id; ?></p>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="d-flex justify-content-end">
            <a href="/html/myReservations.php/" class="btn btn-success me-2">Nie</a>
            <button type="submit" class="btn btn-danger">Tak</button>
        </div>
    </form>
</div>

<?php
include __DIR__."/template/footer.php";
?>