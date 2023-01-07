<?php
include_once __DIR__ . '/../src/Validator.php';
include_once __DIR__ . '/../src/CSRFToken.php';
include_once __DIR__ . '/../src/Mapper/UserMapper.php';
include_once __DIR__ . '/../src/Entity/User.php';

include __DIR__ . '/template/navbar.php';

$validator = new Validator();
$userMapper = new UserMapper();
$csrfToken = new CSRFToken();
$emailErr = $passErr = "";
$email = $pass = "";

if(isset($_SESSION['loggedIn'])){
   Header("Location: /html/myData.php");
   exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['csrf_token'])) {
   if ($csrfToken->verifyToken($_POST['csrf_token'])){
      if (!isset($_POST["email"])) {
        $emailErr = "Podaj email!";
      } else {
        $email = $validator->test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $emailErr = "Email nieprawidłowy";
        }
      }
  
      if (empty($_POST["password"])) {
        $passErr = "Hasło jest wymagane";
      }else{
        $pass = $_POST["password"];
      }
  
     $userMapper->loginUser($email, $pass);
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
                        <h2>Zaloguj się</h2>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-10 offset-md-1">
                     <form action="" method="POST" class="main_form">
                        <?php echo $csrfToken->getTokenInput(); ?>
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