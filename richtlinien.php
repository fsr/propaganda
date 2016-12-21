<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'ldapcfg.php';
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

    <title>Richtlinien für Propaganda des FSR</title>

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
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="antrag.php">Propaganda System des iFSR</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <?php
            echo '<li><a href="antrag.php">Antrag</a></li>';
            if(in_array($username, $memberarray)){
            echo '<li><a href="register.php">Register</a></li>
            <li><a href="archiv.php">Archiv</a></li>
            <li class="active"><a href="richtlinien.php">Richtlinien</a></li>
            </ul><ul class="nav navbar-nav navbar-right">';}
            echo '<li><a href="logout.php">Logout</a></li>';
            ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
      <div class="antrag col-md-9">
        <h1>Richtlinien für Propaganda des FSR</h1>

        <h3>Statusfarben im Register:</h3>
        <p>
          <span class="bg-success">grün</span> : erledigte Propaganda-Anträge<br/>
          <span class="bg-warning">gelb</span> : unfertige Propaganda-Anträge<br/>
          <span class="bg-danger">rot</span> : neue, unangefasste Propaganda-Anträge
        </p>

        <h3>Zurückweisungen:</h3>
        <p>
          Das zurückweisen von Propaganda auf einzelnen Kanälen kann über das System erfolgen. Der Antragsteller sollte darüber in Kentniss gesetzt werden (bestenfalls mit einer Begründung). Dies erfolgt nicht automatisch!
        </p>

        <h3>Propagandakanäle:</h3>
        <p>
          Mittels Tooltip kann bei den Checkboxen der Zeitpunkt der lezten Änderung angezeigt werden.
        </p>

        <h3>Archivieren vs. Löschen:</h3>
        <p>
          Jeder Propaganda-Antrag sollte im Normalfall archiviert werden sobald das Ende der Kampagne erreicht ist oder alle Punkte abgeschlossen sind. Gelöscht werden sollten Einträge nur bei Duplikaten, Fehlern oder auf Wunsch des Antragstellers.
        </p>
      </div>
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="vendor/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
  </body>
</html>
