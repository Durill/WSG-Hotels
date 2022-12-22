<?php
include_once __DIR__ . '/../src/Validator.php';
include_once __DIR__ . '/../src/Responses.php';
include_once __DIR__ . '/../src/UsersMapper.php';
include_once __DIR__ . '/../src/Users.php';

include __DIR__ . '/template/navbar.php';

$validator = new Validator();
$usersMapper = new UsersMapper();
$responses = new Responses();
$response = "";

$nameErr = $surnameErr = $emailErr = $passErr = $rePassErr = "";
$name = $surname = $email = $pass = $rePass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["name"])) {
      $nameErr = "Podaj imię!";
    } else {
      $name = $validator->test_input($_POST["name"]);
      if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $nameErr = "Tylko litery są dozwolone";
      }
    }

    if (empty($_POST["surnname"])) {
      $surnameErr = "Podaj nazwisko!";
    } else {
      $surname = $validator->test_input($_POST["surname"]);
      if (!preg_match("/^[a-zA-Z-' ]*$/",$surname)) {
        $surnameErr = "Tylko litery są dozwolone";
      }
    }

    if (empty($_POST["email"])) {
      $emailErr = "Podaj email!";
    } else {
      $email = $validator->test_input($_POST["email"]);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Email nieprawidłowy";
      }
    }

    if (empty($_POST["password"])) {
      $passErr = "Hasło jest wymagane";
    }

    if (empty($_POST["rePassword"])) {
      $rePassErr = "Hasło jest wymagane";
    }

    $user = new Users($_POST["name"], $_POST["surname"], $_POST["email"], $_POST["password"]);
    $response = $responses->userResponse($usersMapper->registerClient($user));
}


?>
   <div class="contact">
      <?php
         if (strlen($response) > 0){
            echo $response;
         }
      ?>
            <div class="container">
               <div class="row">
                  <div class="col-md-12">
                     <div class="titlepage">
                        <h2>Formularz rejestracji</h2>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-10 offset-md-1">
                     <form id="request" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="main_form">
                        <div class="row">
                           <div class="col-md-12 ">
                              <span class="error"><?php echo $nameErr;?></span>
                              <input class="contactus" placeholder="Imię" type="text" name="name" id="name" value="<?php echo $name;?>" required>
                           </div>
                           <div class="col-md-12">
                              <span class="error"><?php echo $surnameErr;?></span>
                              <input class="contactus" placeholder="Nazwisko" type="text" name="surname" id="surname" value="<?php echo $surname;?>" required>
                           </div>
                           <div class="col-md-12">
                              <span class="error"><?php echo $emailErr;?></span>
                              <input class="contactus" placeholder="E-mail" type="email" name="email" id="email" value="<?php echo $email;?>" required>                     
                           </div>
                           <div class="col-md-12">
                              <span class="error"><?php echo $passErr;?></span> 
                              <input class="contactus" placeholder="Hasło" type="password" name="password" id="password" required>   
                           </div>
                           <div class="col-md-12">
                              <span class="error"><?php echo $rePassErr;?></span>
                              <input class="contactus" placeholder="Powtórz hasło" type="password" name="rePassword" id="rePassword" required>                          
                           </div>
                           <div class="col-md-12">
                              <input class="send_btn" type="submit" value="Zarejestruj">
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
<?php
include __DIR__."/template/footer.php";
?>