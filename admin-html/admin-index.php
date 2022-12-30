<?php
include __DIR__ . '/admin-navbar.php';
if(!isset($_SESSION['adminIn'])){
    Header("Location:admin-login.php");
}
?>

</body>
</html>