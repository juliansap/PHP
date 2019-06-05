<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="login.css">
    <meta charset="UTF-8">
    <title>dumas website</title>
</head>

<body class="bg-dark text-warning">
<?php
include "nav.html";
require 'dbconnect.php';
?>

<?php
session_start();
    $msg ="";
if(isset($_POST['login'])){
$klntnmr = $_POST['klantnummer'];
$ww = $_POST['wachtwoord'];

if (empty($klntnmr) || empty($ww)) {
  $msg = 'Vul uw klantnummer en wachtwoord in.';
}elseif ($msg == '') {
  $squery = "SELECT klantid, beheerdercode, voornaam, wachtwoord FROM klant WHERE klantid = :klantnmr";
  $ostmt = $db->prepare($squery);
  $ostmt->BindValue(':klantnmr', $klntnmr);
  $ostmt->execute();
  $data = $ostmt->fetch();
if ($ostmt->rowCount()==1) {
  if (password_verify($ww,$data['wachtwoord'])) {
    $_SESSION['klantid']=$data['klantid'];
    $_SESSION['voornaam']=$data['voornaam'];
    $_SESSION['beheerdercode']=$data['beheerdercode'];
  if($data['beheerdercode'] == 1){
    $_SESSION['blogin'] = true;
    header('Refresh: 3; url=beheerderpagina.php');
    $msg =  $data['voornaam'] . "<br>" . "u bent succesvol ingelogd als beheerder.";
  }else {
    $_SESSION['klogin'] = true;
    header('Refresh: 3; url=klantpagina.php');
    $msg =  $data['voornaam']. "<br>" . "u bent succesvol ingelogd als klant.";
  }
}else {
  $msf = "het Wachtwoord is niet correct.";
}
}else {
  $msg = "uw staat niet geregistreerd.";
}
}


}

      if ($msg != "") {
        echo '<div class="bg-warning text-dark container" id="errormes">';
        echo $msg . "<br><br>";
        echo '</div>';
      }
    ?>

<form class="box bg-dark" action="login.php" method="post">
    <h1>Login</h1>
    <input type="text" name="klantnummer" placeholder="uw klantnummer">
    <input type="password" name="wachtwoord" placeholder="wachtwoord">
    <button type="submit" name="login" class="loginknop btn my-2 mr-sm-2 btn-outline-warning"><b>Login</b></button>
</form>

</body>
