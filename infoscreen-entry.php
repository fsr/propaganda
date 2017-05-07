<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'ldapcfg.php';

// initialize the database connection
$db = new SQLite3("infoscreen.sqlite");

// check for submitted form data
if (isset($_POST["newSubmit"])) {
    $statement = $db->prepare('INSERT INTO items (headline, content, image, visibility) VALUES (:headline, :content, :image, :visibility);');
		$statement->bindValue(':headline', $_POST['new_headline']);
		$statement->bindValue(':image', $_POST['new_image']);
		$statement->bindValue(':content', $_POST['new_content']);
		$statement->bindValue(':visibility', $_POST['new_visibility']);
		$result = $statement->execute();
    Header("Location: infoscreen.php");
} else if (isset($_POST["editSubmit"])) {
    $statement = $db->prepare('UPDATE items SET headline=:headline, content=:content, image=:image, visibility=:visibility WHERE id = :id;');
		$statement->bindValue(':id', $_POST['updated_id']);
		$statement->bindValue(':headline', $_POST['new_headline']);
		$statement->bindValue(':image', $_POST['new_image']);
		$statement->bindValue(':content', $_POST['new_content']);
		$statement->bindValue(':visibility', $_POST['new_visibility']);
		$result = $statement->execute();
    Header("Location: infoscreen.php");
}

if (isset($_GET["id"])) {
    $statement = $db->prepare('SELECT * FROM items WHERE id = :id;');
		$statement->bindValue(':id', $_GET["id"]);
    $result = $statement->execute();

    $originalEntry = $result->fetchArray();
    if ($originalEntry == false) {
        Header("Location: infoscreen.php");
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

    <?php
        if (isset($_GET["id"])) {
            echo "<title>Infoscreen Eintrag #". $_GET["id"] ." | Propaganda</title>";
        } else {
            echo "<title>Neuer Infoscreen Eintrag | Propaganda</title>";
        }
    ?>

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
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
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
    <div class="antrag col-md-9">
        <?php

        // initialize variables
        $id = "";
        $headline = "";
        $content = "";
        $image = "";
        $visibility = 1;

        // if initial values exist (edit), load them
        if (isset($originalEntry) && $originalEntry != false) {
            $id = $originalEntry["id"];
            $headline = $originalEntry["headline"];
            $content = $originalEntry["content"];
            $image = $originalEntry["image"];
            $visibility = $originalEntry["visibility"];
        }

        if (isset($_GET["id"])) {
            echo "<h1 class='hantrag'>Eintrag #". $_GET["id"] ." bearbeiten</h1>";
        } else {
            echo "<h1 class='hantrag'>Neuer Infoscreen Eintrag</h1>";
        }
        ?>
        
        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="form-group">
                <label for="new_headline" class="col-sm-3 control-label">Überschrift:</label>
                <div class="col-sm-9 input-group">
                    <input type="text" class="form-control" name="new_headline" placeholder="Titel" value="<?php echo $headline; ?>" required />
                </div>
            </div>

            <div class="form-group">
                <label for="new_image" class="col-sm-3 control-label">Bildlink:</label>
                <div class="col-sm-9 input-group">
                    <input type="text" class="form-control" name="new_image" placeholder="Link..." value="<?php echo $image; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label for="new_content" class="col-sm-3 control-label">Text:</label>
                <div class="col-sm-9 input-group">
                    <textarea name="new_content" class="form-control" rows="4" placeholder="Anzeigetext (unterstützt Markdown!)"><?php echo $content; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Sichtbar:</label>
                <div class="col-sm-9 input-group">
                    <?php 
                    if ($visibility == 1) {
                        echo "<label>
                            <input type='radio' name='new_visibility' checked='checked' value='1' /> ja &nbsp;&nbsp;&nbsp;&nbsp;
                        </label>
                        <label>
                            <input type='radio' name='new_visibility' value='0' /> nein
                        </label>";
                    } else {
                        echo "<label>
                            <input type='radio' name='new_visibility' value='1' /> ja &nbsp;&nbsp;&nbsp;&nbsp;
                        </label>
                        <label>
                            <input type='radio' name='new_visibility' checked='checked' value='0' /> nein
                        </label>";
                    }
                    ?>
                </div>
            </div>

            <div class="form-group">
                <?php
                if (isset($_GET["id"])) {
                    echo "<input type='hidden' name='updated_id' value='". $id ."' />
                    <label for='editSubmit' class='col-sm-3 control-label sr-only'>Absenden:</label>
                    <div class='col-sm-9 input-group'>
                        <input name='editSubmit' type='submit' class='btn btn-default' />
                    </div>";
                } else {
                    echo "<label for='newSubmit' class='col-sm-3 control-label sr-only'>Absenden:</label>
                    <div class='col-sm-9 input-group'>
                        <input name='newSubmit' type='submit' class='btn btn-default' />
                    </div>";
                }
                ?>
            </div>

        </form>
    </div>
    <div class="erklaerungen col-md-3">
        <strong>Bitte beachten:</strong> Bild und Text schließen einander aus! Sobald ein Bildlink angegeben wurde, wird der Text ignoriert.
    </div>

</div><!-- /.container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="vendor/jquery-1.11.3.min.js"></script>
<script src="vendor/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>
