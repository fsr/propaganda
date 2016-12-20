<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'ldapcfg.php'
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
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
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
                <li><a href="richtlinien.php">Richtlinien</a></li>"
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    <div class="antrag col-md-9">
        <?php

        //Define Variables
        $title = "";
        $contact = "";
        $begin = "";
        $end = "";
        $propatxt = "";
        $shorttxt = "";
        $links = "";
        $extratxt = "";

        //Checking if Variables have a value sumbitted by form
        if (isset($_POST['titel'])) {
            $title = $_POST['titel'];
        }

        if (isset($_POST['kontakt'])) {
            $contact = $_POST['kontakt'];
        }

        if (isset($_POST['begin'])) {
            $begin = $_POST['begin'];
        }

        if (isset($_POST['ende'])) {
            $end = $_POST['ende'];
        }

        if (isset($_POST['propagandatext'])) {
            $propatxt = $_POST['propagandatext'];
        }

        if (isset($_POST['shorttext'])) {
            $shorttxt = $_POST['shorttext'];
        }

        if (isset($_POST['links'])) {
            $links = $_POST['links'];
        }

        if (isset($_POST['freitext'])) {
            $extratxt = $_POST['freitext'];
        }

        if (isset($_POST['channel1'])) {
            $channelfbs = 1;
        } else {
            $channelfbs = 0;
        }

        if (isset($_POST['channel2'])) {
            $channelfbg = 1;
        } else {
            $channelfbg = 0;
        }

        if (isset($_POST['channel3'])) {
            $channelfbv = 1;
        } else {
            $channelfbv = 0;
        }

        if (isset($_POST['channel4'])) {
            $channeltwi = 1;
        } else {
            $channeltwi = 0;
        }

        if (isset($_POST['channel5'])) {
            $channelwebp = 1;
        } else {
            $channelwebp = 0;
        }

        if (isset($_POST['channel6'])) {
            $channelinfosc = 1;
        } else {
            $channelinfosc = 0;
        }

        if (isset($_POST['channel7'])) {
            $channelnews = 1;
        } else {
            $channelnews = 0;
        }

        if (isset($_POST['channel8'])) {
            $channelplak = 1;
        } else {
            $channelplak = 0;
        }

        //Fileupload
        $uploadfile = "";
        $uploaddir = './upload/';
        $size=0; //Initializing size

        //Checking if a file is uploaded
        if (isset($_FILES['fileupload'])){
        $size = $_FILES['fileupload']; //Needed to compare if a file is selected for upload
        }

        //Scenario for a form with a file
        if ($size['size'] > 0 && isset($_POST['beantragen'])) {
            $fileName = basename($_FILES['fileupload']['name']);

            while (file_exists(($uploaddir . $fileName))) {
                $fileName = "0" . $fileName;
            }
            $uploadfile = $uploaddir . $fileName;
            if (move_uploaded_file($_FILES['fileupload']['tmp_name'], $uploadfile)) {

                //Database
                $status = "todo";
                $db = new SQLite3("items.sqlite"); //Creating database if it doesnt exists
                //Creating Table
                $db->exec("CREATE TABLE IF NOT EXISTS items (id INTEGER PRIMARY KEY, status TEXT, title TEXT, applicantMailAdress TEXT, beginDate TEXT, endDate TEXT, propagandaText TEXT,
                      shortText TEXT, furtherInfos TEXT, fileUrl TEXT, channelFacebookSite INTEGER, channelFacebookGroups INTEGER, channelFacebookEvents INTEGER, channelTwitter INTEGER,
                      channelWebsite INTEGER, channelInfoScreen INTEGER, channelNewsletter INTEGER, channelPosters INTEGER, extraText TEXT, archived INTEGER);");

                //Inserting Statements into the Database
                $statement = $db->prepare('INSERT INTO items (status, title, applicantMailAdress, beginDate, endDate, propagandaText, shortText, furtherInfos, fileUrl,
                      channelFacebookSite, channelFacebookGroups, channelFacebookEvents, channelTwitter, channelWebsite, channelInfoScreen, channelNewsletter, channelPosters,
                      extraText, archived) VALUES (:status, :title, :applicantMailAdress, :beginDate, :endDate, :propagandaText, :shortText, :furtherInfos, :fileUrl, :channelFacebookSite,
                      :channelFacebookGroups, :channelFacebookEvents, :channelTwitter, :channelWebsite, :channelInfoScreen, :channelNewsletter, :channelPosters, :extraText, :archived);');

                $statement->bindValue(':status', $status);
                $statement->bindValue(':title', $title);
                $statement->bindValue(':applicantMailAdress', $contact);
                $statement->bindValue(':beginDate', $begin);
                $statement->bindValue(':endDate', $end);
                $statement->bindValue(':propagandaText', $propatxt);
                $statement->bindValue(':shortText', $shorttxt);
                $statement->bindValue(':furtherInfos', $links);
                $statement->bindValue(':fileUrl', $uploadfile);
                $statement->bindValue(':channelFacebookSite', $channelfbs);
                $statement->bindValue(':channelFacebookGroups', $channelfbg);
                $statement->bindValue(':channelFacebookEvents', $channelfbv);
                $statement->bindValue(':channelTwitter', $channeltwi);
                $statement->bindValue(':channelWebsite', $channelwebp);
                $statement->bindValue(':channelInfoScreen', $channelinfosc);
                $statement->bindValue(':channelNewsletter', $channelnews);
                $statement->bindValue(':channelPosters', $channelplak);
                $statement->bindValue(':extraText', $extratxt);
                $statement->bindValue(':archived', 0);
                //Filling Databse
                $result = $statement->execute();

                echo '<div class="alert alert-success message" role="alert">Dein Antrag ist erfolgreich eingegangen und die Datei wurde hochgeladen!</div>';
            } else {
                echo '<div class="alert alert-danger message" role="alert">Dein Antrag konnte nicht erfolgreich eingereicht werden! Schreibe den Admins!11elf</div>';
            }
        }

        //Scenario for a form without a file
        if (isset($_POST['beantragen']) && $size['size'] == 0) {

            //Database
            $status = "todo";
            $db = new SQLite3("items.sqlite"); //Creating database if it doesnt exists
            //Creating Table
            $db->exec("CREATE TABLE IF NOT EXISTS items (id INTEGER PRIMARY KEY, status TEXT, title TEXT, applicantMailAdress TEXT, beginDate TEXT, endDate TEXT, propagandaText TEXT,
                  shortText TEXT, furtherInfos TEXT, fileUrl TEXT, channelFacebookSite INTEGER, channelFacebookGroups INTEGER, channelFacebookEvents INTEGER, channelTwitter INTEGER,
                  channelWebsite INTEGER, channelInfoScreen INTEGER, channelNewsletter INTEGER, channelPosters INTEGER, extraText TEXT, archived INTEGER);");

            //Inserting Statements into the Database
            $statement = $db->prepare('INSERT INTO items (status, title, applicantMailAdress, beginDate, endDate, propagandaText, shortText, furtherInfos, fileUrl,
                  channelFacebookSite, channelFacebookGroups, channelFacebookEvents, channelTwitter, channelWebsite, channelInfoScreen, channelNewsletter, channelPosters,
                  extraText, archived) VALUES (:status, :title, :applicantMailAdress, :beginDate, :endDate, :propagandaText, :shortText, :furtherInfos, :fileUrl, :channelFacebookSite,
                  :channelFacebookGroups, :channelFacebookEvents, :channelTwitter, :channelWebsite, :channelInfoScreen, :channelNewsletter, :channelPosters, :extraText, :archived);');

            $statement->bindValue(':status', $status);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':applicantMailAdress', $contact);
            $statement->bindValue(':beginDate', $begin);
            $statement->bindValue(':endDate', $end);
            $statement->bindValue(':propagandaText', $propatxt);
            $statement->bindValue(':shortText', $shorttxt);
            $statement->bindValue(':furtherInfos', $links);
            $statement->bindValue(':fileUrl', $uploadfile);
            $statement->bindValue(':channelFacebookSite', $channelfbs);
            $statement->bindValue(':channelFacebookGroups', $channelfbg);
            $statement->bindValue(':channelFacebookEvents', $channelfbv);
            $statement->bindValue(':channelTwitter', $channeltwi);
            $statement->bindValue(':channelWebsite', $channelwebp);
            $statement->bindValue(':channelInfoScreen', $channelinfosc);
            $statement->bindValue(':channelNewsletter', $channelnews);
            $statement->bindValue(':channelPosters', $channelplak);
            $statement->bindValue(':extraText', $extratxt);
            $statement->bindValue(':archived', 0);
            //Filling Database
            $result = $statement->execute();

            echo '<div class="alert alert-success message" role="alert"> Dein Antrag ist erfolgreich eingegangen!</div>';
        } elseif ($_POST['beantragen'] = "") {
            echo '<div class="alert alert-danger message" role="alert">Dein Antrag konnte nicht erfolgreich eingereicht werden! Schreibe den Admins!</div>';
        }
        ?>

        <h1>Antrag auf Propaganda</h1>
        <form action="index.php" method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="form-group">
                <label for="titel" class="col-sm-3 control-label">Betreff:</label>
                <div class="col-sm-9 input-group">
                    <input type="text" class="form-control" name="titel" placeholder="Titel" required>
                </div>
            </div>

            <div class="form-group col-sm-6" id="antragsteller">
                <label for="kontakt" class="col-sm-6 control-label">Antragssteller:</label>
                <div class="col-sm-6 input-group">
                    <input type="text" class="form-control" name="kontakt" placeholder="Nutzer" required>
                    <div class="input-group-addon">@ifsr.de</div>
                </div>
            </div>

            <div class="form-group col-sm-6" id="zeitraum">
                <label for="beginn" class="col-sm-3 control-label">Beginn:</label>
                <div class="col-sm-4 input-group">
                    <input type="date" class="form-control" name="begin"
                           pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}" placeholder="DD.MM.YYYY"
                           required>
                </div>

                <label for="ende" class="col-sm-3 control-label">Ende:</label>
                <div class="col-sm-4 input-group">
                    <input type="date" class="form-control" name="ende"
                           pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}" placeholder="DD.MM.YYYY"
                           required>
                </div>
            </div>

            <div class="form-group">
                <label for="propagandatext" class="col-sm-3 control-label">Propagandatext:</label>
                <div class="col-sm-9 input-group">
                    <textarea name="propagandatext" class="form-control" rows="4" placeholder="Propagandatext"
                              required></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="shorttext" class="col-sm-3 control-label">Kurztext:</label>
                <div class="col-sm-9 input-group">
                    <textarea name="shorttext" class="form-control" rows="2"
                              placeholder="Kurzversion des Propagandatexts, falls nötig"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="links" class="col-sm-3 control-label">Hilfsmittel:</label>
                <div class="col-sm-9 input-group">
                    <textarea name="links" class="form-control" rows="3" placeholder="weiterführende Links"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="fileupload" class="col-sm-3 control-label">Dateiupload:</label>
                <div class="col-sm-9 input-group">
                    <input type="file" name="fileupload">
                    <p class="help-block">Illustration, Aushang, etc.</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Propagandakanäle:</label>
                <div class="col-sm-9 form-group" name="channels">
                    <label>
                        <input type="checkbox" name="channel1"> Facebook Seite
                    </label>
                    <label>
                        <input type="checkbox" name="channel2"> Facebook Gruppen
                    </label>
                    <label>
                        <input type="checkbox" name="channel3"> Facebook Veranstaltung
                    </label>
                    <label>
                        <input type="checkbox" name="channel4"> Twitter
                    </label>
                    <label>
                        <input type="checkbox" name="channel5"> Webseite
                    </label>
                    <label>
                        <input type="checkbox" name="channel6"> Infoscreen
                    </label>
                    <label>
                        <input type="checkbox" name="channel7"> Newsletter
                    </label>
                    <label>
                        <input type="checkbox" name="channel8"> Plakate / Aufsteller
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="freitext" class="col-sm-3 control-label">Freitext:</label>
                <div class="col-sm-9 input-group">
                    <textarea name="freitext" class="form-control" rows="3"
                              placeholder="weitere Anmerkungen"></textarea>
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
