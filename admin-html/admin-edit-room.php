<?php
include_once __DIR__ . '/../src/Validator.php';
include_once __DIR__ . '/../src/CSRFToken.php';
include_once __DIR__ . '/../src/Mapper/RoomMapper.php';
include_once __DIR__ . '/../src/Entity/Room.php';
include __DIR__ . '/admin-navbar.php';
if(!isset($_SESSION['adminIn'])){
    Header("Location: /admin-html/admin-login.php");
}

$csrfToken = new CSRFToken();
$validator = new Validator();
$roomMapper = new RoomMapper();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['csrf_token'])) {
    if ($csrfToken->verifyToken($_POST['csrf_token'])){
        $id = $places = $price = $type = "";

        if (isset($_POST["id"])) {
        $id = $validator->test_input($_POST["id"]);
        }

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
        $room->setId($id);
        $roomMapper->updateRoom($room);
    }
}

$room = "";
if (isset($_GET['id'])){
    $room = $roomMapper->getRoom($_GET['id']);
    if(!$room){
        Header("Location: /html/errorPage.php");
    }
} else {
    Header("Location: /html/errorPage.php");
}

?>
<div class="container-md mt-5">
    <?php
    if(isset($_SESSION['status'])){
        if (strlen($_SESSION['status']) > 0){
            echo $_SESSION['status'];
            unset($_SESSION['status']);
        }
    }
    ?>
    <form action="" method="POST">
        <?php echo $csrfToken->getTokenInput(); ?>
        <div class="mb-3">
            <label for="places" class="form-label">Ilość miejsc</label>
            <input value="<?php echo $room->getPlaces(); ?>"required type="number" class="form-control" name="places" id="places" min="1" max="10">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Cena (za dzień)</label>
            <input value="<?php echo $room->getPrice(); ?>" required type="number" class="form-control" name="price" id="price" min="1" max="100000000" step="0.01">
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Rodzaj</label>
            <select required class="form-select" aria-label="Default select example" name="type">
                <?php
                    foreach (RoomType::cases() as $type) {
                        if($room->getType() == $type->value){
                            echo '<option selected value="'.$type->value.'">'.ucfirst($type->value).'</option>';
                        } else {
                            echo '<option value="'.$type->value.'">'.ucfirst($type->value).'</option>';
                        }
                    }
                ?>
                
            </select>
        </div>
        <input type="hidden" name="id" value="<?php echo $room->getId(); ?>">
        <div class="d-flex flex-row-reverse">
            <button type="submit" class="btn btn-primary">Zapisz</button>
            <a href="/admin-html/admin-rooms.php/" class="btn btn-warning me-2">Anuluj</a>
        </div>
    </form>
</div>
</body>
</html>