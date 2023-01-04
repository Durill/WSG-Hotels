<?php
include __DIR__ . '/admin-navbar.php';
if(!isset($_SESSION['adminIn'])){
    Header("Location: /admin-html/admin-login.php");
}
?>
<?php
    if(isset($_SESSION['adminStatus'])){
        if (strlen($_SESSION['adminStatus']) > 0){
            echo $_SESSION['adminStatus'];
        }
	 }
?>
</body>
</html>