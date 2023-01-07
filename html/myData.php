<?php
include __DIR__ . '/template/navbar.php';
include_once __DIR__ . '/../src/CSRFToken.php';
include_once __DIR__ . '/../src/Validator.php';
include_once __DIR__ . '/../src/Mapper/UserMapper.php';
include_once __DIR__ . '/../src/Entity/User.php';

if(!isset($_SESSION['loggedIn'])){
    Header("Location: /html/login.php");
    exit();
}

$csrfToken = new CSRFToken();
$validator = new Validator();
$user = new User();
$userMapper = new UserMapper();

if(isset($_SESSION['id'])){
    $user = $userMapper->getUserData($_SESSION['id']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['csrf_token'])) {
    if ($csrfToken->verifyToken($_POST['csrf_token'])){
        if(isset($_POST['dataChanger'])){
            $userNewData = new User();
            $userNewData->setId($validator->test_input($_SESSION['id']));
            $userNewData->setName($validator->test_input($_POST['name']));
            $userNewData->setSurname($validator->test_input($_POST['surname']));
            $userMapper->updateUserData($userNewData);
            $user = $userMapper->getUserData($_SESSION['id']);
        }elseif(isset($_POST['passwordChanger'])){
            $userMapper->updateUserPassword(
                $_SESSION['id'], 
                array($validator->test_input($_POST['oldPassword']), 
                    $validator->test_input($_POST['newPassword']), 
                    $validator->test_input($_POST['newRePassword'])
                    )
                );
        }elseif(isset($_POST['emailChanger'])){
            $userMapper->updateUserEmail($_SESSION['id'], $validator->test_input($_POST['email']));
            $user = $userMapper->getUserData($_SESSION['id']);
        }
    }
}

?>

<div class="container-sm mt-2 userData">
    <?php
      if(isset($_SESSION['status'])){
        if (strlen($_SESSION['status']) > 0){
           echo $_SESSION['status'];
           unset($_SESSION['status']);
        }
     }
    ?>

  <br>
  <h2>Moje Dane</h2>
  <form action="" method="POST" class="dataForms d-md-none">
    <?php echo $csrfToken->getTokenInput(); ?>
    <div class="d-flex gap-3 dataRows flex-wrap">
        <div>
            <p class="mb-0">Imię:</p>
            <input class="form-control mb-2" type="text" id="name" value="<?php echo $user->getName(); ?>" name="name">
        </div>
        <div>
            <p class="mb-0">Nazwisko:</p>
            <input class="form-control mb-0" type="text" id="surname" value="<?php echo $user->getSurname(); ?>" name="surname">
        </div>
        <div class="d-flex flex-column-reverse">
            <button type="submit" class="btn btn-primary" name="dataChanger">Zmień dane</button>
        </div>
    </div>
  </form>
  <form action="" method="POST" class="dataForms d-none d-md-block">
    <?php echo $csrfToken->getTokenInput(); ?>
    <div class="d-flex gap-3 dataRows flex-wrap">
        <div class="d-flex justify-content-around align-items-start flex-column">
            <p class="mb-0">Imię:</p>
            <p class="mb-0">Nazwisko:</p>
        </div>
        <div>
            <input class="form-control mb-2" type="text" id="name" value="<?php echo $user->getName(); ?>" name="name">
            <input class="form-control mb-0" type="text" id="surname" value="<?php echo $user->getSurname(); ?>" name="surname">
        </div>
        <div class="d-flex flex-column-reverse">
            <button type="submit" class="btn btn-primary" name="dataChanger">Zmień dane</button>
        </div>
    </div>
  </form>
  <br>
  <br>
  <h2>Mój Email</h2>
  <form action="" method="POST" class="dataForms d-md-none">
    <?php echo $csrfToken->getTokenInput(); ?>
    <div class="d-flex gap-3 dataRows flex-wrap">
        <div>
            <p class="mb-0">Email:</p>
            <input class="form-control mb-2" type="email" id="email" value="<?php echo $user->getEmail(); ?>" name="email" style="min-width:240px;">
        </div>
        <div class="d-flex flex-column-reverse">
            <button type="submit" class="btn btn-primary" name="emailChanger">Zmień email</button>
        </div>
    </div>
  </form>
  <form action="" method="POST" class="dataForms d-none d-md-block">
    <?php echo $csrfToken->getTokenInput(); ?>
    <div class="d-flex gap-3 dataRows flex-wrap">
        <div class="d-flex justify-content-around align-items-start flex-column">
            <p class="mb-0">Email:</p>
        </div>
        <div>
            <input class="form-control" type="email" id="email" value="<?php echo $user->getEmail(); ?>" name="email" style="min-width:240px;">
        </div>
        <div class="d-flex flex-column-reverse">
            <button type="submit" class="btn btn-primary" name="emailChanger">Zmień email</button>
        </div>
    </div>
  </form>
  <br>
  <br>
  <h2>Hasło</h2>
  <form action="" method="POST" class="dataForms d-md-none">
    <?php echo $csrfToken->getTokenInput(); ?>
    <div class="d-flex gap-3 dataRows flex-wrap">
        <div>
            <p class="mb-0">Aktualne hasło:</p>
            <input class="form-control mb-2" type="password" id="oldPassword" name="oldPassword">
        </div>
        <div>
            <p class="mb-0">Nowe hasło:</p>
            <input class="form-control mb-2" type="password" id="newPassword" name="newPassword">
        </div>
        <div>
            <p class="mb-0">Powtórz nowe hasło:</p>
            <input class="form-control mb-2" type="password" id="newRePassword" name="newRePassword">
        </div>
        <div class="d-flex flex-column-reverse">
            <button type="submit" class="btn btn-primary" name="passwordChanger">Zmień hasło</button>
        </div>
    </div>
  </form>
  <form action="" method="POST" class="dataForms d-none d-md-block">
    <?php echo $csrfToken->getTokenInput(); ?>
    <div class="d-flex gap-3 dataRows flex-wrap">
        <div class="d-flex justify-content-around align-items-start flex-column">
            <p class="mb-0">Aktualne hasło:</p>
            <p class="mb-0">Nowe hasło:</p>
            <p class="mb-0">Powtórz nowe hasło:</p>
        </div>
        <div>
            <input class="form-control mb-2" type="password" id="oldPassword" name="oldPassword">
            <input class="form-control mb-2" type="password" id="newPassword" name="newPassword">
            <input class="form-control" type="password" id="newRePassword" name="newRePassword">
        </div>
        <div class="d-flex flex-column-reverse">
            <button type="submit" class="btn btn-primary" name="passwordChanger">Zmień hasło</button>
        </div>
    </div>
  </form>

</div>

<?php
include __DIR__."/template/footer.php";
?>