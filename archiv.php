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

    <title>Propaganda Archiv</title>

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
          <a class="navbar-brand" href="index.php">Propagandasystem des <br class="rwd-break"> iFSR<br class="rwd-break"></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <?php
            echo '<li><a href="antrag.php">Antrag</a></li>';
            echo '<li><a href="mantrag.php">Meine Anträge</a></li>';
            if (in_array($username, $memberarray)) {
                echo '<li><a href="register.php">Register</a></li>
            <li class="active"><a href="archiv.php">Archiv</a></li>
            <li><a href="richtlinien.php">Richtlinien</a></li>';
            }
            echo '</ul><ul class="nav navbar-nav navbar-right">
            <li><a href="logout.php">Logout</a></li>';
            ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
      <div class="antrag col-md-12">
        <h1>Propaganda Archiv</h1>

        <table class="table">
          <tr>
            <th></th>
            <th>ID</th>
            <th>Titel</th>
            <th>Antragsteller</th>
            <th>Beginn</th>
            <th>Ende</th>
            <th>FB-Seite</th>
            <th>FB-Gruppen</th>
            <th>FB-Event</th>
            <th>Twitter</th>
            <th>Webseite</th>
            <th>Infoscreen</th>
            <th>Newsletter</th>
            <th>Plakate</th>
          </tr>
          <?php

          function channelIcon($channelStatus)
          {
              if ($channelStatus==1) {
                  return "✔";
              } else {
                  return "✗";
              }
          }

          $db = new SQLite3("items.sqlite");

          if (isset($_POST["delete_id"])) {
              $delete = $db->prepare('DELETE FROM items WHERE id = :id;');
              $delete->bindValue(':id', $_POST['delete_id']);
              $result = $delete->execute();
              $smail = $username ."@ifsr.de";
              $message = "Hey Team,\nthis is your Propaganda system!\n\nA request was deleted in your archiv !\n\nYou can check it out at ".$page;
              $header = 'From: '.$smail . "\r\n" . 'Reply-To: '.$smail . "\r\n" . 'X-Mailer: PHP/' . phpversion();
              mail($email, '[FSR-ÖA] A Request was deleted in your archiv from ' . $smail, $message, $header);
          }

          $numberOfRow = 0;
          //todo = ROT, inProgress = GELB, done = grün
          $statement = $db->prepare("SELECT * FROM items WHERE archived = 1");
          $result = $statement->execute();

          while ($row = $result->fetchArray()) {
              if (!empty($row)) {
                  echo "<tr class='active'>";
                  echo "<td data-toggle='collapse' data-target='#tr".$numberOfRow."' aria-expanded='false' aria-controls='#tr".$numberOfRow."'>
                <i class='fa fa-fw fa-chevron-right'></i>
                <i class='fa fa-fw fa-chevron-down'></i>
              </td>
              <td>".$row["id"]."</td>
              <td>".$row["title"]."</td>
              <td><a href='mailto:".$row["applicantMailAdress"]."@ifsr.de'>".$row["applicantMailAdress"]."</a></td>
              <td>".$row["beginDate"]."</td>
              <td>".$row["endDate"]."</td>
              <td>";
                  echo channelIcon($row["channelFacebookSite"]);
                  echo "</td>
              <td>";
                  echo channelIcon($row["channelFacebookGroups"]);
                  echo "</td>
              <td>";
                  echo channelIcon($row["channelFacebookEvents"]);
                  echo "</td>
              <td>";
                  echo channelIcon($row["channelTwitter"]);
                  echo "</td>
              <td>";
                  echo channelIcon($row["channelWebsite"]);
                  echo "</td>
              <td>";
                  echo channelIcon($row["channelInfoScreen"]);
                  echo "</td>
              <td>";
                  echo channelIcon($row["channelNewsletter"]);
                  echo "</td>
              <td>";
                  echo channelIcon($row["channelPosters"]);
                  echo "</td>
            </tr>
            <tbody id='tr".$numberOfRow."' class='collapse'>
              <tr class='active'>
                <td></td>
                <td colspan='13'>
                  <p><strong>Propagandatext: </strong>
                  ";
                  echo $row["propagandaText"];
                  echo "
                  </p>
                  <p><strong>Kurztext: </strong> ";
                  echo $row ["shortText"];
                  echo " </p>
                  <p><strong>Uploads: </strong> ";
                  if ($row["fileUrl"] != "") {
                      echo "<a href='".$row["fileUrl"]."'>File</a>";
                  } else {
                      echo "";
                  }
                  echo "</p>
                  <p><strong>Links: </strong>";
                  echo $row["furtherInfos"];
                  echo "</p>
                  <p><strong>Freitext: </strong> ";
                  echo $row["extraText"];
                  echo "</p>

                  <form method='post'>
                    <input type='hidden' name='delete_id' value='";
                  echo $row["id"];
                  echo "' />
                    <button class='btn btn-default pull-right' type='submit'>archivierten Antrag löschen</button>
                  </form>
                </td>
              </tr>

            </tbody>";
                  $numberOfRow += 1;
              }
          }

          ?>
        </table>
      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="vendor/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>

    <script>
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    </script>
  </body>
</html>
