<?php

function redirectOnLogin(){
    if(isset($_SESSION['user'])) {
        $url ='antrag.php';
        ob_end_clean(); // Delete the buffer
        header("Location: $url");
        exit(); #quit
    }
}

session_start();
if (isset($_POST['username'])) {
    $username = $_POST['username'];
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
}
  if (isset($_POST["senden"])) {
      $_SESSION['user']=$_POST['username'];
      $_SESSION['password']=$_POST['password'];
      header("Location:antrag.php");
  }
 ?>
