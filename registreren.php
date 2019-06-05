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
require ("dbconnect.php");
include "nav.html";
?>

<?php

    $msg = "";

    if(isset($_POST['registreer'])) {

      $voornaam = $_POST['voornaam'];
      $achternaam = $_POST['achternaam'];
      $gbdatum = $_POST['geboortedatum'];
      $woonplaats = $_POST['woonplaats'];
      $email = $_POST['email'];
      if (empty($_POST['email'])) {
        $email = "";
      }
      $nieuws = "Nee";
      if ($_POST['nieuws'] == 0) {
        $nieuws = "Nee";
      }elseif ($_POST['nieuws'] == 1) {
        $nieuws = "Ja";
      } else {
        $msg = "kies of u onze nieuwsbrief wilt ontvangen";
      }
      $ww1 = $_POST['wachtwoord1'];
      $ww2 = $_POST['wachtwoord2'];
      if (empty($voornaam) || empty($achternaam) || empty($gbdatum) || empty($woonplaats) || empty($ww1) || empty($ww2)) {
        $msg = "Vul alles in.";
      }

      if (!empty($email)) {
        $sql = $db->prepare("SELECT klantid FROM klant WHERE email = '$email'");
        $sql->execute();
        if($sql->rowCount() > 0){
          if ($msg == "") {
            $msg = "het email addres is al in gebruik.";
          }else{
            $msg = $msg."<br>Het email addres is al in gebruik.<br>";
          }
        }
      }

        if ($ww1 != $ww2) {
          if ($msg == "") {
            $msg = "de wachtwoorden zijn niet gelijk.";
          } else {
            $msg = $msg."<br>de wachtwoorden zijn niet gelijk.";
          }
        }

        if ( $nieuws =="Ja" && $email =="")  {
          if ($msg == "") {
            $msg =  "Als u de nieuwsbrief wilt ontvangen moet uw uw email addres invullen.";
          } else {
            $msg = $msg. "<br>Als u de nieuwsbrief wilt ontvangen moet u uw email addres invullen";
          }
        }


        if ($msg =="") {
          $ww=password_hash($ww1, PASSWORD_DEFAULT);

            $squery = "INSERT INTO klant (voornaam, achternaam, geboortedatum, woonplaats, email, nieuwsbrief, wachtwoord) VALUES (:voornaam, :achternaam, :geboortedatum, :woonplaats, :email, :nieuwsb, :wachtwoord)";
            $ostmt = $db->prepare($squery);
            $ostmt->BindValue(':voornaam', $voornaam);
            $ostmt->BindValue(':achternaam', $achternaam);
            $ostmt->BindValue(':geboortedatum', $gbdatum);
            $ostmt->BindValue(':woonplaats', $woonplaats);
            $ostmt->BindValue(':email', $_POST['email']);
            $ostmt->BindValue(':nieuwsb', $nieuws);
            $ostmt->BindValue(':wachtwoord', $ww);
            $ostmt->execute();
            $msg = "uw bent geregistreerd. <br> vergeet uw klantnummer niet uw moet hier mee inloggen uw klantnummer is  " . $db->lastInsertid();
            header('Refresh: 5; index.php');
          }

    }

            if ($msg !=  "") {
              echo '<div class="bg-warning container text-dark">';
              echo $msg . "<br>";
              echo '</div>';
            }


?>


<form  class="container" action="registreren.php" method="post" class="registratie">

        <h1>Registreren</h1>

        <br>

            <label for="klantnummer"><b>Klantnummer</b></label><br>
            <input class="registratieinput" type="text" name="klantnummer" placeholder="Klant nummer word automatisch gemaakt." disabled><br><br><br>

            <label for="voornaam"><b>Voornaam</b></label><br>
            <input  class="registratieinput" type="text" name="voornaam" placeholder="Voornaam" required><br><br>

            <label for="achternaam"><b>Achternaam</b></label><br>
            <input  class="registratieinput" type="text" name="achternaam" placeholder="Achternaam" required><br><br>

            <label for="geboortedatum"><b>Geboortedatum</b></label><br>
            <input class="registratieinput" type="date" name="geboortedatum" required><br><br>

            <label for="woonplaats"><b>Woonplaats</b></label><br>
            <input  class="registratieinput" type="text" name="woonplaats" placeholder="Woonplaats" required><br><br>

            <label for="email"><b>Email</b></label><br>
            <input  class="registratieinput" type="email" name="email" placeholder="Email, is optineel"><br><br>

            <label for="wachtwoord1"><b>Wachtwoord</b></label><br>
            <input  class="registratieinput" type="password" name="wachtwoord1" placeholder="Wachtwoord" required><br><br>

            <label for="wachtwoord2"><b>Herhaal Wachtwoord</b></label><br>
            <input  class="registratieinput" type="password" name="wachtwoord2" placeholder="Wachtwoord" required><br><br><br>

            <label for="nieuwsbrief"><b>Wilt u onze nieuwsbriefontvangen?</b></label><br>

            <select class="registratieinput" name="nieuws">
              <option selected>kies</option>
              <option value="1">ja ik wil graag een nieuwsbrief.</option>
              <option value="0">nee ik wil geen  nieuwsbrief.</option>
            </select>

            <br><br>

            <button type="submit" name="registreer" class="registeerknop btn-outline-warning btn-dark"><b>Registreer</b></button>


</form>
</body>
</html>
