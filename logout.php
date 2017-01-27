<?php
session_start();
if (isset($_SESSION['user'])) {
    session_destroy(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="favicon.ico">

<title>Propaganda System Logout</title>

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
<div class="container">
<div class="col-md-12">
<div class="col-xs-4"></div>
<div class="col-xs-4">
<?php
echo "<div role='success' class='alert alert-success'>";
    echo "<strong>Sie wurden erfolgreich ausgeloggt!</strong><br/>Sie werden automatisch weitergeleitet, wenn nicht dann <a class='site' href='index.php'>hier</a> klicken.";
    echo "</div>";
    echo "<meta http-equiv='refresh' content='3; URL=index.php'/>";
    die();
}
?>
</div>
<div class="col-xs-4"></div>
</div>
</body>
</html>
