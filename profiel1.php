
<?php
session_start();
include "bnav.php";
require "dbconnect.php";
try {
  $ostmt = $db->prepare("SELECT * FROM klant WHERE klantid = :klantid");
  $ostmt->bindValue(':klantid', $_SESSION['klantid']);
  $ostmt->execute();
  $data = $ostmt->fetch(PDO::FETCH_ASSOC);
  $_SESSION['email']=$data['email'];
} catch (\Exception $e) {
  die("error!: " . $e->getMessage());
}

if(isset($_POST['update'])) {
$msg = "";

$voornaam = $_POST['voornaam'];
$achternaam = $_POST['achternaam'];
$gbdatum = $_POST['geboortedatum'];
$woonplaats = $_POST['woonplaats'];
$email = $_POST['email'];
$nieuws = $_POST['nieuwsbrief'];

if(!empty($nieuws) || !empty($email)){
if ( $nieuws =="Ja" && $email =="")  {
  if ($msg == "") {
    $msg =  "Als u de nieuwsbrief wilt ontvangen moet uw uw email adres invullen.";
  }
}
}
if(!empty($email)){
if ($_SESSION['email'] != $email) {
  $oldemail = $_SESSION['email'];
  $sql = $db->prepare("SELECT klantid FROM klant WHERE email = '$email'");
  $sql->execute();
  if($sql->rowCount() >= 1){
    if ($msg == "") {
      $msg = "het email adres is al in gebruik.";
    }else{
      $msg = $msg."<br>Het email adres is al in gebruik.<br>";
    }
  }
}
}
if ($msg == "") {
$query = "UPDATE klant SET voornaam = :voornaam, achternaam = :achternaam, geboortedatum = :geboortedatum, woonplaats = :woonplaats, email = :email, nieuwsbrief = :nieuwsbrief WHERE klantid LIKE :klantid";
$ostmt = $db->prepare($query);
$ostmt->bindValue(':klantid', $_SESSION['klantid']);
$ostmt->bindValue(':voornaam', $voornaam);
$ostmt->bindValue(':achternaam', $achternaam);
$ostmt->bindValue(':geboortedatum', $gbdatum);
$ostmt->bindValue(':woonplaats', $woonplaats);
$ostmt->bindValue(':email', $email);
$ostmt->bindValue(':nieuwsbrief', $nieuws);
$ostmt->execute();
header('Refresh: 0; url=profiel1.php');
$_SESSION['email'] = $email;
}

if ($msg != "") {
echo '<div class="bg-warning text-dark container" id="errormes">';
echo $msg . "<br><br>";
echo '</div>';
}
}


 ?>
<!DOCTYPE html>
<html lang="nl" dir="ltr">
  <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="profielcss.php">
    <meta charset="utf-8">
    <title>dumas</title>
  </head>
  <body class="bg-dark text-warning">


    <main class="container">
        <form action="profiel1.php" method="post">
          <input class="form-control" type="text" value="<?php echo $data['klantid']; ?>" name="klantiddata" disabled>
          <label>Voornaam</label>
          <input class="form-control" type="text" value="<?php echo $data['voornaam']; ?>" name="voornaam"><br>
          <label>Achternaam</label>
          <input class="form-control" type="text" value="<?php echo $data['achternaam']; ?>" name="achternaam"><br>
          <label>Geboortedatum</label>
          <input class="form-control" type="text" value="<?php echo $data['geboortedatum']; ?>" name="geboortedatum"><br>
          <label>Woonplaats</label>
          <input class="form-control" type="text" value="<?php echo $data['woonplaats']; ?>" name="woonplaats"><br>
          <label>E-mail</label>
          <input class="form-control" type="email" value="<?php echo $data['email']; ?>" name="email"><br>
          <label>nieuwsbrief</label>
          <input class="form-control mr-sm-6" type="text" value="<?php echo $data['nieuwsbrief']; ?>" name="nieuwsbrief"><br>
          <label></label>

          <button class="btn btn-block btn-warning" type="submit" name="update">Verander</button><br>
        </form>

        <aside
  </body>
</html>
