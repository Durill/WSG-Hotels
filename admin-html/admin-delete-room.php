<?php
include_once __DIR__ . '/../src/Validator.php';
include_once __DIR__ . '/../src/Mapper/RoomMapper.php';
include_once __DIR__ . '/../src/Entity/Room.php';
include __DIR__ . '/admin-navbar.php';
if(!isset($_SESSION['adminIn'])){
    Header("Location: /admin-html/admin-login.php");
}

$validator = new Validator();
$roomMapper = new RoomMapper();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $places = $price = $type = "";

    if (isset($_POST["id"])) {
      $id = $validator->test_input($_POST["id"]);
    }

    $roomMapper->deleteRoom($id);
}

$id = "";
if (isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];
} else {
    Header("Location: /html/errorPage.php");
}

?>
<div class="container-md mt-5" style="max-width: 500px;">
    <form action="" method="POST" class="border rounded-1 border-primary p-2">
        <p>Czy na pewno chcesz usunąć ten pokój?</p>
        <p>ID pokoju: <?php echo $id; ?></p>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="d-flex justify-content-end">
            <a href="/admin-html/admin-rooms.php/" class="btn btn-success me-2">Nie</a>
            <button type="submit" class="btn btn-danger">Tak</button>
        </div>
    </form>
</div>
</body>
</html>