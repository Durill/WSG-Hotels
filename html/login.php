<?php
include_once __DIR__ . '/../src/Validator.php';
include_once __DIR__ . '/../src/Mapper/UserMapper.php';
include_once __DIR__ . '/../src/Entity/User.php';

include __DIR__ . '/template/navbar.php';

$validator = new Validator();
$userMapper = new UserMapper();
$response = "";

$emailErr = $passErr = "";
$email = $pass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST["email"])) {
      $emailErr = "Podaj email!";
    } else {
      $email = $validator->test_input($_POST["email"]);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Email nieprawidłowy";
      }
    }

    if (!isset($_POST["password"])) {
      $passErr = "Hasło jest wymagane";
    } else{
      $pass = $_POST["password"];
    }

   $response = $userMapper->loginUser($email, $pass);
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
                        <h2>Zaloguj się</h2>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-10 offset-md-1">
                     <form id="request" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="main_form">
                        <div class="row">
                           <div class="col-md-12">
                              <span class="error"><?php echo $emailErr;?></span>
                              <input class="contactus" placeholder="E-mail" type="email" name="email" id="email" value="<?php echo $email;?>" required>                     
                           </div>
                           <div class="col-md-12">
                              <span class="error"><?php echo $passErr;?></span> 
                              <input class="contactus" placeholder="Hasło" type="password" name="password" id="password" required>   
                           </div>
                           <div class="col-md-12">
                              <input class="send_btn" type="submit" value="Zaloguj">
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