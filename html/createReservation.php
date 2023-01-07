<?php
include __DIR__ . '/template/navbar.php';
include_once __DIR__ . '/../src/Validator.php';
include_once __DIR__ . '/../src/CSRFToken.php';
include_once __DIR__ . '/../src/Mapper/ReservationMapper.php';

if(!isset($_SESSION['loggedIn'])){
    Header("Location: /html/login.php");
    exit();
}
$validator = new Validator;
$csrfToken = new CSRFToken();
$reservationMapper = new ReservationMapper();

if (isset($_SESSION['second_step'])){
    unset($_SESSION['available_rooms']);
    unset($_SESSION['from_date']);
    unset($_SESSION['to_date']);
}


if (isset($_POST['from_date']) && isset($_POST['to_date']) && isset($_POST['csrf_token'])) {
    if ($csrfToken->verifyToken($_POST['csrf_token'])){
        $from_date = $validator->test_input($_POST['from_date']);
        $to_date = $validator->test_input($_POST['to_date']);
        $reservationMapper->selectReservationDates($from_date, $to_date);
    }
}

?>

<div class="container-sm mb-5">
    <div class="mt-2">
        <?php
        if(isset($_SESSION['status'])){
            if (strlen($_SESSION['status']) > 0){
            echo $_SESSION['status'];
            unset($_SESSION['status']);
            }
        }
        ?>
    </div>
    <br>
  <h2>Zarezerwuj pokój</h2>
  <br>
  <form action="" method="POST" class="d-md-none">
    <?php echo $csrfToken->getTokenInput(); ?>
    <div class="d-flex gap-3 flex-wrap">
        <div>
            <p class="mb-0">Od:</p>
            <input class="form-control mb-0" type="date" id="from_date" name="from_date">
        </div>
        <div>
            <p class="mb-0">Do:</p>
            <input class="form-control mb-0" type="date" id="to_date" name="to_date">
        </div>
        <div class="d-flex flex-column-reverse">
            <button type="submit" class="btn btn-primary">Dalej</button>
        </div>
    </div>
  </form>
  <form action="" method="POST" class="d-none d-md-block">
    <?php echo $csrfToken->getTokenInput(); ?>
    <div class="d-flex gap-3 flex-wrap">
        <div class="d-flex justify-content-around align-items-start flex-column">
            <p class="mb-0">Od:</p>
            <p class="mb-0">Do:</p>
        </div>
        <div>
            <input class="form-control mb-2" type="date" id="from_date" name="from_date">
            <input class="form-control mb-0" type="date" id="to_date" name="to_date">
        </div>
        <div class="d-flex flex-column-reverse">
            <button type="submit" class="btn btn-primary">Dalej</button>
        </div>
    </div>
  </form>
</div>
<?php
include __DIR__."/template/footer.php";
?>