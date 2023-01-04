<?php
include __DIR__ . '/template/navbar.php';

if(!isset($_SESSION['loggedIn'])){
    Header("Location: /html/login.php");
    exit();
}

if(isset($_SESSION['status'])){
    if (strlen($_SESSION['status']) > 0){
        echo $_SESSION['status'];
        unset($_SESSION['status']);
    }
}
?>

<?php
include __DIR__."/template/footer.php";
?>