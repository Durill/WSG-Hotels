<?php
include_once __DIR__ . '/../src/Validator.php';
include_once __DIR__ . '/../src/Mapper/AdminMapper.php';
include_once __DIR__ . '/../src/Entity/Admin.php';

$validator = new Validator();
$adminMapper = new AdminMapper();
$username = $password = $usernameErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST["username"])) {
        $usernameErr = "Podaj login!";
    } else {
        $username = $validator->test_input($_POST["username"]);
    }

    if (empty($_POST["password"])) {
      $passwordErr = "Hasło jest wymagane";
    } else{
      $password = $_POST["password"];
    }

    $admin = new Admin($username, $password);
    $adminMapper->loginAdmin($admin);
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
	</head>
    <style>
        * {
  	box-sizing: border-box;
  	font-family: -apple-system, BlinkMacSystemFont, "segoe ui", roboto, oxygen, ubuntu, cantarell, "fira sans", "droid sans", "helvetica neue", Arial, sans-serif;
  	font-size: 16px;
  	-webkit-font-smoothing: antialiased;
  	-moz-osx-font-smoothing: grayscale;
}
body {
  	background-color: #435165;
}
.login {
  	width: 400px;
  	background-color: #ffffff;
  	box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.3);
  	margin: 100px auto;
}
.login h1 {
  	text-align: center;
  	color: #5b6574;
  	font-size: 24px;
  	padding: 20px 0 20px 0;
  	border-bottom: 1px solid #dee0e4;
}
.login form {
  	display: flex;
  	flex-wrap: wrap;
  	justify-content: center;
  	padding-top: 20px;
}
.login form label {
  	display: flex;
  	justify-content: center;
  	align-items: center;
  	width: 50px;
  	height: 50px;
  	background-color: #3274d6;
  	color: #ffffff;
}
.login form input[type="password"], .login form input[type="text"] {
  	width: 310px;
  	height: 50px;
  	border: 1px solid #dee0e4;
  	margin-bottom: 20px;
  	padding: 0 15px;
}
.login form input[type="submit"] {
  	width: 100%;
  	padding: 15px;
 	margin-top: 20px;
  	background-color: #3274d6;
  	border: 0;
  	cursor: pointer;
  	font-weight: bold;
  	color: #ffffff;
  	transition: background-color 0.2s;
}
.login form input[type="submit"]:hover {
	background-color: #2868c7;
  	transition: background-color 0.2s;
}
.comeBack{
    text-align:center;
    font-size:12px;
    padding:5px;
    color: #0d85a3;
}
    </style>
	<body>
    <?php
      if(isset($_SESSION['adminStatus'])){
		if (strlen($_SESSION['adminStatus']) > 0){
		   echo $_SESSION['adminStatus'];
		}
	 }
      ?>
		<div class="login">
			<h1>Admin Panel - Logowanie</h1>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <span class="error"><?php echo $usernameErr;?></span>
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Login" id="username" value="<?php echo $username;?>" required>
                <span class="error"><?php echo $passwordErr;?></span>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Hasło" id="password" required>
                <a href="/html/register.php" class="comeBack">Wróć do strony głównej</a>
				<input type="submit" value="Zaloguj">
			</form>
		</div>
	</body>
</html>