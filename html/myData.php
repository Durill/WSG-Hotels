<?php
include __DIR__ . '/template/navbar.php';
include_once __DIR__ . '/../src/Mapper/UserMapper.php';
include_once __DIR__ . '/../src/Entity/User.php';

if(!isset($_SESSION['loggedIn'])){
    Header("Location:login.php");
    exit();
}

$user = new User();
$userMapper = new UserMapper();
$response = "";

if(isset($_SESSION['id'])){
    $user = $userMapper->getUserData($_SESSION['id']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['dataChanger'])){
        $userChanger = new User();
        $userChanger->setId($_SESSION['id']);
        $userChanger->setName($_POST['name']);
        $userChanger->setSurname($_POST['surname']);
        $userChanger->setEmail($_POST['email']);
        $response = $userMapper->updateUserData($userChanger);
        $user = $userMapper->getUserData($_SESSION['id']);
    }elseif(isset($_POST['passwordChanger'])){
        echo 'passwordChanger';
    }
}

?>

<div class="container-fluid userData">
    <?php
        if (strlen($response) > 0){
            echo $response;
        }
    ?>
    <br>
  <h2>Moje Dane</h2>
  <br>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="dataForms">
    <div class="row dataRows">
        <div class="col-1"><p>Imię:</p></div>
        <div class="col-2"><input class="form-control" type="text" id="name" value="<?php echo $user->getName(); ?>" name="name"></div>
    </div>
    <div class="row dataRows">
        <div class="col-1"><p>Nazwisko:</p></div>
        <div class="col-2"><input class="form-control" type="text" id="surname" value="<?php echo $user->getSurname(); ?>" name="surname"></div>
    </div>
    <div class="row dataRows">
        <div class="col-1"><p>Email:</p></div>
        <div class="col-2"><input class="form-control" type="email" id="email" value="<?php echo $user->getEmail(); ?>" name="email"></div>
    </div>
    <br>
    <div class="row dataRows">
        <div class="col-1"></div>
        <div class="col-1"><button type="submit" class="btn btn-primary" name="dataChanger">Zmień dane</button></div>
    </div>
  </form>
  <br>
  <h2>Hasło</h2>
  <br>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="passForms">
    <div class="row dataRows">
        <div class="col-1"><p>Aktualne hasło:</p></div>
        <div class="col-2"><input type="password" class="form-control" id="oldPassword" name="oldPassword"></div>
    </div>
    <div class="row dataRows">
        <div class="col-1"><p>Nowe hasło:</p></div>
        <div class="col-2"><input type="password" class="form-control" id="newPassword" name="newPassword"></div>
    </div>
    <div class="row dataRows">
        <div class="col-1"><p>Powtórz nowe hasło:</p></div>
        <div class="col-2"><input type="password" class="form-control" id="newRePassword" name="newRePassword"></div>
    </div>
    <br>
    <div class="row dataRows">
        <div class="col-1"></div>
        <div class="col-1"><button type="submit" class="btn btn-primary" name="passwordChanger">Zmień hasło</button></div>
    </div>
  </form>
</div>

<?php
include __DIR__."/template/footer.php";
?>