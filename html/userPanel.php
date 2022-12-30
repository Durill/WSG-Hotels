<?php 
session_start();
if(isset($_SESSION['name'])) {
    echo "User: ".$_SESSION['name']. ' loggedIn: '.$_SESSION['loggedIn'].' user: '.$_SESSION['isUser'];
  } else {
    echo "No user";
  }
?>
