<?php
include_once __DIR__ . '/../src/Validator.php';
include_once __DIR__ . '/../src/CSRFToken.php';
include_once __DIR__ . '/../src/Mapper/UserMapper.php';
include_once __DIR__ . '/../src/Entity/User.php';
include __DIR__ . '/template/navbar.php';


if(isset($_SESSION['loggedIn'])){
   Header("Location: /html/myData.php");
   exit();
}

$validator = new Validator();
$csrfToken = new CSRFToken();
$userMapper = new UserMapper();
$nameErr = $surnameErr = $emailErr = $passErr = $rePassErr = "";
$name = $surname = $email = $pass = $rePass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['csrf_token'])) {
   if ($csrfToken->verifyToken($_POST['csrf_token'])){
      if (empty($_POST["name"])) {
         $nameErr = "Podaj imię!";
      } else {
         $name = $validator->test_input($_POST["name"]);
         if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
         $nameErr = "Tylko litery są dozwolone";
         }
      }

      if (empty($_POST["surname"])) {
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
      }{
         $pass = $_POST["password"];
      }

      if (empty($_POST["rePassword"])) {
         $passErr = "Hasło jest wymagane";
      }else{
         $rePass = $_POST["rePassword"];
      }

      $user = new User();
      $user->setUserForRegistration($name, $surname, $email, $pass, $rePass);
      $userMapper->registerUser($user);
   }
}


?>
   <div class="contact">
      <div class="container-sm">
         <?php
         if(isset($_SESSION['status'])){
            if (strlen($_SESSION['status']) > 0){
               echo $_SESSION['status'];
               unset($_SESSION['status']);
            }
         }
         ?>
      </div>
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
                        <?php echo $csrfToken->getTokenInput(); ?>   
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