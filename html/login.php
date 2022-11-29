<?php
include __DIR__."/template/navbar.php";
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
                     <form id="request" action="" method="POST" autocomplete="off" class="main_form">
                        <div class="row">
                           <div class="col-md-12 ">
                              <input class="contactus" placeholder="Imię" type="text" name="name" id="name" required> 
                           </div>
                           <div class="col-md-12">
                              <input class="contactus" placeholder="Nazwisko" type="text" name="surname" id="surname" required> 
                           </div>
                           <div class="col-md-12">
                              <input class="contactus" placeholder="E-mail" type="email" name="email" id="email" required>                          
                           </div>
                           <div class="col-md-12">
                              <input class="contactus" placeholder="Hasło" type="password" name="password" id="password" required>                          
                           </div>
                           <div class="col-md-12">
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