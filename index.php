<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Propagandasystem des iFSR</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Propagandasystem des <br class="rwd-break"> iFSR<br class="rwd-break"></a>
        </div>
    </div>
</nav>
<br />
<div class="container">
<div clas="main">
  <div class="col-xs-3">
  </div>
  <div class="col-xs-6">
      <form class="form-signin" action="index.php" method="post">
        <label class="sr-only">Username</label>
        <input type="input" name="username" class="form-control" placeholder="Username" required autofocus/>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Password" required/><br/><br/>
        <button class="btn btn-lg btn-primary btn-block" name="senden" type="submit">Sign in</button>
      </form>
      <br/><br/>
      <?php
      if (isset($_POST['username'])) {
          $username = $_POST['username'];
      }
      if (isset($_POST['password'])) {
          $password = $_POST['password'];
      }
        if (isset($_POST["senden"])) {
            $_SESSION['user']=$_POST['username'];
            $_SESSION['password']=$_POST['password'];
            echo "<div role='success' class='alert alert-success'>";
            echo "<strong>Sie werden nun weitergeleitet, wenn nicht dann <a class='site' href='antrag.php'>hier</a> klicken.</strong>";
            echo "</div>";
            echo "<meta http-equiv='refresh' content='2; URL=antrag.php'/>";
        }
       ?>
  </div>
  <div class="col-xs-3">
  </div>
</div>
</div><!-- /.container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="vendor/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>
