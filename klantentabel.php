<?php session_start(); ?>
<?php

require"dbconnect.php";
  if(isset($_POST['wijzig'])) {
    $voornaam = $_POST['voornaam'];
    $klantid =  $_POST['klantid'];
    $beheer = $_POST['beheerdercode'];
    $achter =  $_POST['achternaam'];
    $squery = "UPDATE klant SET beheerdercode = :beheerdercode, voornaam = :voornaam, achternaam = :achternaam WHERE klantid = :klantid";
    $ostmt = $db->prepare($squery);
    $ostmt->bindValue(':klantid', $klantid);
    $ostmt->bindValue(':beheerdercode', $beheer);
    $ostmt->bindValue(':voornaam', $voornaam);
    $ostmt->bindValue(':achternaam', $achter);
    $ostmt->execute();


  }

  if(isset($_POST['wis'])){
    $klantid = $_POST['klantid'];
    $squery = "DELETE FROM klant WHERE klantid = :klantid";
    $ostmt = $db->prepare($squery);
    $ostmt->BindValue(':klantid', $klantid );
    $ostmt->execute();



  }

 ?>
<!DOCTYPE html>
<html lang="nl" dir="ltr">
  <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body class="bg-dark text-warning">
    <?php
      include"bnav.php";


      $squery = "SELECT * FROM klant ORDER BY beheerdercode DESC";
      $ostmt = $db->prepare($squery);
      $ostmt->execute();

      echo"<div class='container'>";
      echo"<table class='table' border='1'";
      echo"<thead>
        <td>Klant-id</td>
        <td>Beheerdercode</td>
        <td>Voornaam</td>
        <td>Achternaam</td>
        <td colspan='2'>Actie</td>
        </thead>";
        while($data =  $ostmt->fetch(PDO::FETCH_ASSOC))  {
    ?>
      <form action="klantentabel.php" method="post">
        <tr>
          <td><input type="text" name="klantid" value="<?php echo ($data['klantid']); ?>"  readonly></td>
          <td><input type="text" name="beheerdercode" value="<?php echo ($data['beheerdercode']); ?>" ></td>
          <td><input type="text" name="voornaam" value="<?php echo ($data['voornaam']); ?>"readonly></td>
          <td><input type="text" name="achternaam" value="<?php echo ($data['achternaam']); ?>"readonly></td>

      <?php
        if ($data['klantid'] != $_SESSION['klantid']) {
            ?>
          <td><input type="submit" name="wijzig" value="Wijzig" class="btn my-2 mr-sm-2 btn-outline-warning"></td>
          <td><input type="submit" name="wis" value="Wis" onclick="return confirm('<?php echo($data['voornaam']); ?> wordt verwijderd, weet u het zeker?')" class="btn my-2 mr-sm-2 btn-outline-warning"></td>
      <?php
        }
      ?>
        </tr>
      </form>
    <?php
      }
    ?>



  </body>
</html>
