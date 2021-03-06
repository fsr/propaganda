<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'ldapcfg.php';
include 'Parsedown.php';

// initialize the database connection
$db = new SQLite3("infoscreen.sqlite");

// if a change to the visibility of certain objects was made: apply it
if (isset($_POST["changeVisibility"])) {
    $statement = $db->prepare('UPDATE items SET visibility=:visibility WHERE id = :id;');
	$statement->bindValue(':id', $_POST['editedId']);
	$statement->bindValue(':visibility', $_POST['new_visibility']);
	$result = $statement->execute();
}
if(isset($_POST['deleteEntry'])) {
		$statement = $db->prepare('DELETE FROM items WHERE id = :id;');
		$statement->bindValue(':id', $_POST['deleteId']);
		$result = $statement->execute();
}

function displayState($status){
    if ($status == 0) {
        return "danger";//Rot
    } else {
        return "success";//Grün
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

    <link rel="stylesheet" href="vendor/font-awesome-4.7.0/css/font-awesome.min.css">
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
        <?php 
            // report whether database update went well
            if (isset($_POST["changeVisibility"])) {
                if ($result == false) {
                    echo "<div role='danger' class='alert alert-danger'><strong>Beim Verarbeiten der Datenbankabfrage ist ein Fehler aufgetreten!</strong></div>";
                } else {
                    echo "<div role='success' class='alert alert-success'>Sichtbarkeit erfolgreich aktualisiert!</div>";
                }
            } else if (isset($_POST["deleteEntry"])) {
                if ($result == false) {
                    echo "<div role='danger' class='alert alert-danger'><strong>Beim Löschen ist ein Fehler aufgetreten!</strong></div>";
                } else {
                    echo "<div role='success' class='alert alert-success'>Eintrag erfolgreich gelöscht!</div>";
                }
            }
            
        ?>

        <h1>Infoscreen Backend</h1>

        <table class="table">
          <tr>
            <th></th>
            <th>ID</th>
            <th>Überschrift</th>
          </tr>

        <?php
        // initialize the Markdown parser
        $Parsedown = new Parsedown();

	    $db->exec("CREATE TABLE IF NOT EXISTS items (id INTEGER PRIMARY KEY, headline TEXT, content TEXT, image TEXT, visibility INTEGER);");

        $res = $db->query("SELECT * FROM items;");
        
        while ($row = $res->fetchArray()) { ?>

            <tr class="<?php echo displayState($row["visibility"]); ?>">
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
                <tr class='". displayState($row["visibility"]) ."'>"; ?>
                    <td></td>
                    <?php
                    if ($row["image"] != "") {
                        echo "<td><b>Bildlink:</b></td>
                        <td><a href='". $row["image"] ."'>". $row["image"] ."</a></td>";
                    } else {
                        echo "<td><b>Text:</b></td>
                        <td>". $Parsedown->text($row["content"]) ."</td>";
                    }
                    ?>
                </tr>
                <?php echo "<tr class='". displayState($row["visibility"]) ."'>"; ?>
                    <td></td>
                    <td><b>Sichtbar?</b></td>
                    <td><form action="infoscreen.php" method="POST"><?php
                        echo "<input type='hidden' name='editedId' value='". $row["id"] ."' />";
                        if ($row["visibility"] == 1) {
                            echo "<label>Ja <input type='radio' name='new_visibility' value='1' checked='checked' /></label> &nbsp;&nbsp;&nbsp;&nbsp; <label>Nein <input type='radio' name='new_visibility' value='0' /></label>";
                        } else {
                            echo "<label>Ja <input type='radio' name='new_visibility' value='1' /></label> &nbsp;&nbsp;&nbsp;&nbsp; <label>Nein <input type='radio' name='new_visibility' value='0' checked='checked' /></label>";
                        }
                    ?><br />
                    <button class='btn btn-default pull-right' type='submit' name='changeVisibility'>Sichtbarkeit aktualisieren</button>
                    </form><?php echo "<a href='infoscreen-entry.php?id=". $row["id"] ."' class='btn btn-default pull-right'>Eintrag bearbeiten</a>
                    <form action='infoscreen.php' method='POST'>
                        <input type='hidden' name='deleteId' value='". $row["id"] ."' />
                        <button class='btn btn-default pull-right' type='submit' name='deleteEntry'>Eintrag löschen</button>
                    </form>"; ?></td>
                </tr>
            </tbody>

        <?php
        }
        ?>

          <tr>
            <td></td>
            <td></td>
            <td><a href="infoscreen-entry.php?new" class="btn btn-default pull-right">Neuen Eintrag anlegen</a></td>
          </tr>

        </table>
      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="vendor/jquery-1.11.3.min.js"></script>
    <script src="vendor/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>

    <script>
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    </script>
  </body>
</html>
