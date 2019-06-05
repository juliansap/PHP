<?php session_start(); ?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="registratie.css">
    <meta charset="UTF-8">
    <title>dumas website</title>
</head>

<body class="bg-dark text-warning">
<?php
require "dbconnect.php";
include "bnav.php";
?>

<?php

    $msg = "";

    if(isset($_POST['wijzig'])) {
      $oww = $_POST['oudww'];
      $ww1 = $_POST['ww1'];
      $ww2 = $_POST['ww2'];
    if($ww1 == $ww2){
      $klantid = $_SESSION['klantid'];
      $squery = "SELECT wachtwoord FROM klant WHERE klantid = :klantid";
      $ostmt = $db->prepare($squery);
      $ostmt->BindValue(':klantid', $klantid);
      $ostmt->execute();
      $data = $ostmt->fetch();
    if (password_verify($oww,$data['wachtwoord'])) {
      $ww=password_hash($ww1, PASSWORD_DEFAULT);
      $squery = "UPDATE klant SET wachtwoord = :wachtwoord WHERE klantid = :klantid";
      $ostmt = $db->prepare($squery);
      $ostmt->BindValue(':klantid', $_SESSION['klantid']);
      $ostmt->BindValue(':wachtwoord', $ww);
      $ostmt->execute();
      $msg = "uw wachtwoord is gewijzigd.";
    }else{
      $msg = "het oude wachtwoord klopt niet.";
    }
    }else{
      $msg = "het nieuwe wachtwoord is niet goed geherhaald.";
    }
    }

    if ($msg !=  "") {
      echo '<div class="bg-warning container text-dark">';
      echo $msg . "<br>";
      echo '</div>';
    }

?>


<form  class="container" action="wwwijzigen1.php" method="post" class="registratie">

        <h1>Wachtwoord wijzigen</h1>

        <br>

            <label for="oudww"><b>Oud wachtwoord</b></label><br>
            <input class="registratieinput" type="password" name="oudww" placeholder="Oud wachtwoord"><br><br><br>

            <label for="voornaam"><b>Nieuw wachtwoord</b></label><br>
            <input  class="registratieinput" type="password" name="ww1" placeholder="Nieuw wachtwoord" required><br><br>

            <label for="achternaam"><b>Herhaal wachtwoord</b></label><br>
            <input  class="registratieinput" type="password" name="ww2" placeholder="Herhaal Wachtwoord" required><br><br>

            <button type="submit" name="wijzig" class="btn btn-warning btn-lg btn-block"><b>wijzig</b></button>


</form>
</body>
</html>
