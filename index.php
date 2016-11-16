<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Antrag auf Propaganda</title>

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
          <a class="navbar-brand" href="index.php">Propaganda</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Antrag</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="archiv.php">Archiv</a></li>
            <li><a href="richtlinien.php">Richtlinien</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
      <div class="antrag col-md-9">
        <h1>Antrag auf Propaganda</h1>
        <form action="index.php" method="post" enctype="multipart/form-data" class="form-horizontal">
          <div class="form-group">
            <label for="titel" class="col-sm-3 control-label">Betrifft:</label>
            <div class="col-sm-9 input-group">
              <input type="text" class="form-control" name="titel" placeholder="Titel">
            </div>
          </div>

          <div class="form-group col-sm-6" id="antragsteller">
            <label for="kontakt" class="col-sm-6 control-label">Antragssteller:</label>
            <div class="col-sm-6 input-group">
              <input type="text" class="form-control" name="kontakt" placeholder="Nutzer">
              <div class="input-group-addon">@ifsr.de</div>
            </div>
          </div>

          <div class="form-group col-sm-6" id="zeitraum">
            <label for="beginn" class="col-sm-3 control-label">Beginn:</label>
            <div class="col-sm-3 input-group">
              <input type="date" class="form-control" name="kontakt">
            </div>

            <label for="ende" class="col-sm-3 control-label">Ende:</label>
            <div class="col-sm-3 input-group">
              <input type="date" class="form-control" name="ende">
            </div>
          </div>

          <div class="form-group">
            <label for="propagandatext" class="col-sm-3 control-label">Propagandatext:</label>
            <div class="col-sm-9 input-group">
              <textarea name="propagandatext" class="form-control" rows="4" placeholder="Propagandatext"></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="shorttext" class="col-sm-3 control-label">Kurztext:</label>
            <div class="col-sm-9 input-group">
              <textarea name="shorttext" class="form-control" rows="2" placeholder="Kurzversion des Propagandatexts, falls nötig"></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="links" class="col-sm-3 control-label">Hilfsmittel:</label>
            <div class="col-sm-9 input-group">
              <textarea name="links" class="form-control" rows="3" placeholder="weiterführende Links"></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="fileupload" class="col-sm-3 control-label sr-only">Dateiupload:</label>
            <div class="col-sm-9 input-group">
              <input type="file" name="fileupload">
              <p class="help-block">Illustration, Aushang, etc.</p>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label">Propagandakanäle:</label>
            <div class="col-sm-9 form-group" name="channels">
              <label>
                <input type="checkbox"> Facebook Seite
              </label>
              <label>
                <input type="checkbox"> Facebook Gruppen
              </label>
              <label>
                <input type="checkbox"> Facebook Veranstaltung
              </label>
              <label>
                <input type="checkbox"> Twitter
              </label>
              <label>
                <input type="checkbox"> Webseite
              </label>
              <label>
                <input type="checkbox"> Infoscreen
              </label>
              <label>
                <input type="checkbox"> Newsletter
              </label>
              <label>
                <input type="checkbox"> Plakate / Aufsteller
              </label>
            </div>
          </div>

          <div class="form-group">
            <label for="freitext" class="col-sm-3 control-label">Freitext:</label>
            <div class="col-sm-9 input-group">
              <textarea name="freitext" class="form-control" rows="3" placeholder="weitere Anmerkungen"></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="beantragen" class="col-sm-3 control-label sr-only">Absenden:</label>
            <div class="col-sm-9 input-group">
              <button name="beantragen" type="submit" class="btn btn-default">Beantragen</button>
            </div>
          </div>

        </form>
      </div>

      <?php
        $title = $_POST['titel'];
        $contact = $_POST['kontakt'];
        $begin = $_POST['beginn'];
        $end = $_POST['ende'];
        $propatxt = $_POST['propagandatext'];
        $shorttxt = $_POST['shorttext'];
        $links = $_POST['links'];
        $fupload = $_POST['fileupload'];
        $channels = $_POST['channels'];
        $extratxt = $_POST['freitext'];

        echo $channels;
       ?>

      <div class="erklaerungen col-md-3">
        <!-- Hier ist Platz für Erklärungen und Anmerkungen -->
      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="vendor/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
  </body>
</html>
