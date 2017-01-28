<?php
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
