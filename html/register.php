<?php
include __DIR__ . '/../src/Validation.php';
include __DIR__ . '/template/navbar.php';

$nameErr = $surnameErr = $emailErr = $passErr = $rePassErr = "";
$name = $surname = $email = $pass = $rePass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["name"])) {
      $nameErr = "Podaj imię!";
    } else {
      $name = test_input($_POST["name"]);
      if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $nameErr = "Tylko litery są dozwolone";
      }
    }

    if (empty($_POST["surnname"])) {
      $surnameErr = "Podaj nazwisko!";
    } else {
      $surname = test_input($_POST["name"]);
      if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $surnameErr = "Tylko litery są dozwolone";
      }
    }

    if (empty($_POST["email"])) {
      $emailErr = "Podaj email!";
    } else {
      $email = test_input($_POST["email"]);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Email nieprawidłowy";
      }
    }

    if (empty($_POST["password"])) {
      $passErr = "Hasło jest wymagane";
    }

    if (empty($_POST["password"])) {
      $rePassErr = "Hasło jest wymagane";
    }


   registerClient($_POST["name"], $_POST["surname"], $_POST["email"], $_POST["password"]);
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
 }
?>
   <div class="contact">
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
                              <input class="contactus" placeholder="Imię" type="text" name="name" id="name" value="<?php echo $name;?>" required>
                              <span class="error"><?php echo $nameErr;?></span>
                           </div>
                           <div class="col-md-12">
                              <input class="contactus" placeholder="Nazwisko" type="text" name="surname" id="surname"value="<?php echo $surname;?>" required>
                              <span class="error"><?php echo $surnameErr;?></span>
                           </div>
                           <div class="col-md-12">
                              <input class="contactus" placeholder="E-mail" type="email" name="email" id="email" value="<?php echo $email;?>" required>
                              <span class="error"><?php echo $emailErr;?></span>                     
                           </div>
                           <div class="col-md-12">
                              <input class="contactus" placeholder="Hasło" type="password" name="password" id="password" required>   
                              <span class="error"><?php echo $passErr;?></span>                       
                           </div>
                           <div class="col-md-12">
                              <input class="contactus" placeholder="Powtórz hasło" type="password" name="rePassword" id="rePassword" required>
                              <span class="error"><?php echo $rePassErr;?></span>                          
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