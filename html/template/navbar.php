<?php
   session_start();
?>
<!DOCTYPE html>
<html lang="pl">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <title>WSG - Hotels</title>
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/own-style.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
   </head>
   <body class="main-layout">
   <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <div class="container-fluid">
         <a class="navbar-brand" href="#">
            <img src="images/BSG-LOGO-wh.png" alt="Logo" style='width:60px;height:auto;'>
         </a>
         <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
         </button> -->
         <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
            <li class="nav-item">
               <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#">O Nas</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#">Oferta</a>
            </li>  
            <?php
               if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
                  echo '<li class="nav-item dropdown">
                           <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                           <img src="images/profile-icon.png" alt="Logo" style="width:30px;height:auto;opacity:0.55;">
                           </a>
                           <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="#">Rezerwuj</a></li>
                              <li><a class="dropdown-item" href="#">Moje Rezerwacje</a></li>
                              <li><a class="dropdown-item" href="/html/myData.php">Moje Dane</a></li>
                              <li><a class="dropdown-item" href="/html/logout.php">Wyloguj</a></li>
                           </ul>
                        </li>';
               }else{
                  echo '<li class="nav-item">
                           <a class="nav-link" href="/html/login.php">Zaloguj</a>
                        </li>';
                  echo '<li class="nav-item">
                           <a class="nav-link" href="/html/register.php">Zarejestruj</a>
                        </li>';
               }
            ?>
            </ul>
         </div>
      </div>
   </nav>
