<?php
include_once __DIR__ . '/../src/Validator.php';
include_once __DIR__ . '/../src/Mapper/RoomMapper.php';
include_once __DIR__ . '/../src/Entity/Room.php';
include __DIR__ . '/admin-navbar.php';
if(!isset($_SESSION['adminIn'])){
    Header("Location:admin-login.php");
}

$validator = new Validator();
$roomMapper = new RoomMapper();
$placesErr = $priceErr = $typeErr = "";
$places = $price = $type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["places"])) {
      $places = $validator->test_input($_POST["places"]);
    }

    if (isset($_POST["price"])) {
      $price = $validator->test_input($_POST["price"]);
    }

    if (isset($_POST["type"])) {
      $type = $validator->test_input($_POST["type"]);
    }

    $room = new Room($places, $price, $type);
    $roomMapper->createRoom($room);
}

if(isset($_SESSION['status'])){
    if (strlen($_SESSION['status']) > 0){
        echo $_SESSION['status'];
        unset($_SESSION['status']);
    }
}
?>
<div class="container-md mt-5">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div class="mb-3">
            <label for="places" class="form-label">Ilość miejsc</label>
            <input required type="number" class="form-control" name="places" id="places" min="1" max="10">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Cena (za dzień)</label>
            <input required type="number" class="form-control" name="price" id="price" min="1" max="100000000" step="0.01">
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Rodzaj</label>
            <select required class="form-select" aria-label="Default select example" name="type">
                <?php
                    foreach (RoomType::cases() as $type) {
                        echo '<option value="'.$type->value.'">'.ucfirst($type->value).'</option>';
                    }
                ?>
                
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Dodaj pokój</button>
    </form>
</div>
</body>
</html>