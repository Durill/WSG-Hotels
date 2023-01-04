<?php
include __DIR__ . '/template/navbar.php';
include_once __DIR__ . '/../src/Validator.php';
include_once __DIR__ . '/../src/Mapper/ReservationMapper.php';

if(!isset($_SESSION['loggedIn'])){
    Header("Location: /html/login.php");
    exit();
}
$validator = new Validator;
$reservationMapper = new ReservationMapper();

if (isset($_SESSION['second_step'])){
    unset($_SESSION['available_rooms']);
    unset($_SESSION['from_date']);
    unset($_SESSION['to_date']);
}


if (isset($_POST['from_date']) && isset($_POST['to_date'])) {
    $from_date = $validator->test_input($_POST['from_date']);
    $to_date = $validator->test_input($_POST['to_date']);
    $reservationMapper->selectReservationDates($from_date, $to_date);
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
  <form action="" method="POST" class="dataForms">
    <div class="row dataRows">
        <div class="col-1"><p>Od:</p></div>
        <div class="col-2"><input class="form-control" type="date" id="from_date" name="from_date"></div>
    </div>
    <div class="row dataRows">
        <div class="col-1"><p>Do:</p></div>
        <div class="col-2"><input class="form-control" type="date" id="to_date" name="to_date"></div>
    </div>
    <br>
    <div class="row dataRows">
        <div class="col-1"></div>
        <div class="col-1"><input type="submit" class="btn btn-primary" value="Dalej"></input></div>
    </div>
  </form>
</div>
<?php
include __DIR__."/template/footer.php";
?>