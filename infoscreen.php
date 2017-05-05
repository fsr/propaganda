<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'ldapcfg.php';

function rowColor($status) {
    if ($status == 0) {
        return "danger"; //Rot
    } elseif ($status == 1) {
        return "success"; //Grün
    }
}
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

    <title>Infoscreen Management | Propaganda</title>

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
          <a class="navbar-brand" href="index.php">Propagandasystem <br class="rwd-break">des iFSR<br class="rwd-break"></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <?php
            echo '<li><a href="antrag.php">Antrag</a></li>';
            echo '<li><a href="mantrag.php">Meine Anträge</a></li>';
            if (in_array($username, $memberarray)) {
                echo '<li><a href="register.php">Register</a></li>
            <li class="active"><a href="infoscreen.php">Infoscreen</a></li>
            <li><a href="archiv.php">Archiv</a></li>
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
        <h1>Infoscreen Backend</h1>

        <table class="table">
          <tr>
            <th></th>
            <th>ID</th>
            <th>Überschrift</th>
          </tr>

        <?php
	    $db = new SQLite3("infoscreen.sqlite");
	    $db->exec("CREATE TABLE IF NOT EXISTS items (id INTEGER PRIMARY KEY, headline TEXT, content TEXT, image TEXT, visibility INTEGER);");

        $res = $db->query("SELECT * FROM items;");
        
        while ($row = $res->fetchArray()) { ?>

            <tr class="<?php echo rowColor($row["visibility"]); ?>">
                <?php echo "<td data-toggle='collapse' data-target='#tr". $row["id"] ."' aria-expanded='false' aria-controls='#tr". $row["id"] ."'>"; ?>
                    <i class='fa fa-fw fa-chevron-right'></i>
                    <i class='fa fa-fw fa-chevron-down'></i>
                </td>
                <td>
                    <?php echo $row["id"]; ?>
                </td>
                <td>
                    <?php echo $row["headline"]; ?>
                </td>
            </tr>
            <?php echo "<tbody id='tr". $row["id"] ."' class='collapse'>
                <tr class='". rowColor($row["visibility"]) ."'>"; ?>
                    <td></td>
                    <?php
                    if ($row["image"] != "") {
                        echo "<td>Bildlink:</td>
                        <td><a href='". $row["image"] ."'>". $row["image"] ."</a></td>";
                    } else {
                        echo "<td>Text:</td>
                        <td>". $row["content"] ."</td>";
                    }
                    ?>
                </tr>
            </tbody>

        <?php
        }
        ?>

           
            <?php
            /*
            while ($row = $result->fetchArray()) {
                if (!empty($row)) {
                    echo "<tr class='";
                    echo rowColor($row["status"]);
                    echo "'>";
                    echo " <td data-toggle='collapse' data-target='#tr".$numberOfRow."' aria-expanded='false' aria-controls='#tr".$numberOfRow."'>
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
              <tr class='";
                    echo rowColor($row["status"]);
                    echo "'>
                <td></td>
                <td colspan='13'>
                  <p><strong>Propagandatext: </strong>
                  ";
                    echo $row["propagandaText"];
                    echo "
                  </p>
                  <p><strong>Kurztext: </strong> ";
                    echo $row ["shortText"];
                    echo "</p>
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
                  <p><strong>Freitext: </strong>";
                    echo $row["extraText"];
                    echo "</p></tr>
                  <tr class='";
                    echo rowColor($row["status"]);
                    echo "'>
                    <form method='post'>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan='2'>Angenommen</td>
                    <td><input type='radio' name='group1' value='accep1' required";
                    if (channelChecked($row["channelFacebookSite"])) {
                        echo " checked='checked'";
                    }
                    echo "></td>
                    <td><input type='radio' name='group2' value='accep2' required";
                    if (channelChecked($row["channelFacebookGroups"])) {
                        echo " checked='checked'";
                    }
                    echo "></td>
                    <td><input type='radio' name='group3' value='accep3' required";
                    if (channelChecked($row["channelFacebookEvents"])) {
                        echo " checked='checked'";
                    }
                    echo "></td>
                    <td><input type='radio' name='group4' value='accep4' required";
                    if (channelChecked($row["channelTwitter"])) {
                        echo " checked='checked'";
                    }
                    echo "></td>
                    <td><input type='radio' name='group5' value='accep5' required";
                    if (channelChecked($row["channelWebsite"])) {
                        echo " checked='checked'";
                    }
                    echo "></td>
                    <td><input type='radio' name='group6' value='accep6' required";
                    if (channelChecked($row["channelInfoScreen"])) {
                        echo " checked='checked'";
                    }
                    echo "></td>
                    <td><input type='radio' name='group7' value='accep7' required";
                    if (channelChecked($row["channelNewsletter"])) {
                        echo " checked='checked'";
                    }
                    echo "></td>
                    <td><input type='radio' name='group8' value='accep8' required";
                    if (channelChecked($row["channelPosters"])) {
                        echo " checked='checked'";
                    }
                    echo "></td>
                  </tr>
                  <tr class='";
                    echo rowColor($row["status"]);
                    echo "'>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan='2'>Abgelehnt</td>
                    <td><input type='radio' name='group1' required";
                    if (!channelChecked($row["channelFacebookSite"])) {
                        echo " checked='checked'";
                    }
                    echo "></td>
                    <td><input type='radio' name='group2' required";
                    if (!channelChecked($row["channelFacebookGroups"])) {
                        echo " checked='checked'";
                    }
                    echo "></td>
                    <td><input type='radio' name='group3' required";
                    if (!channelChecked($row["channelFacebookEvents"])) {
                        echo " checked='checked'";
                    }
                    echo "></td>
                    <td><input type='radio' name='group4' required";
                    if (!channelChecked($row["channelTwitter"])) {
                        echo " checked='checked'";
                    }
                    echo "></td>
                    <td><input type='radio' name='group5' required";
                    if (!channelChecked($row["channelWebsite"])) {
                        echo " checked='checked'";
                    }
                    echo "></td>
                    <td><input type='radio' name='group6' required";
                    if (!channelChecked($row["channelInfoScreen"])) {
                        echo " checked='checked'";
                    }
                    echo "></td>
                    <td><input type='radio' name='group7' required";
                    if (!channelChecked($row["channelNewsletter"])) {
                        echo " checked='checked'";
                    }
                    echo "></td>
                    <td><input type='radio' name='group8' required";
                    if (!channelChecked($row["channelPosters"])) {
                        echo " checked='checked'";
                    }
                    echo "></td>
                    </tr>

                    <tr class='";
                    echo rowColor($row["status"]);
                    echo "'>
                    <td></td>
                    <td colspan='13'>
                    <input type='hidden' name='update_id' value='";
                    echo $row["id"];
                    echo "' />
                    <button class='btn btn-default pull-right' type='submit'>Genehmigungen setzen</button>
                    </form>
                    <form method='post'>
                      <input type='hidden' name='delete_id' value='";
                    echo $row["id"];
                    echo "' />
                      <button class='btn btn-default pull-right' type='submit'>Antrag löschen</button>
                    </form>
                    <form method='post'>
                      <input type='hidden' name='archive_id' value='";
                    echo $row["id"];
                    echo "' />
                      <button class='btn btn-default pull-right' type='submit'>Antrag archivieren</button>
                    </form>
                    <form method='post'>
                      <input type='hidden' name='progress_id' value='";
                    echo $row["id"];
                    echo "' />
                      <button class='btn btn-default pull-right' type='submit'>Antrag in Bearbeitung</button>
                    </form>
                    <form method='post'>
                      <input type='hidden' name='done_id' value='";
                    echo $row["id"];
                    echo "' />
                      <button class='btn btn-default pull-right' type='submit'>Antrag erledigt</button>
                    </form>
                </td>
              </tr>
            </tbody>";
                    $numberOfRow += 1;
                }
            }
        }
        */
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