<?php session_start(); ?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>dumas website</title>
</head>

    <body class="bg-dark text-warning">
<?php
include "knav.php";
require "dbconnect.php";
?>

<?php
        $zoek = $_POST['search'];
        if(empty($zoek)) {
            echo "vul een merk in";
        }
        else {
            try{
                $squery = "SELECT productenid, artikel, merk, prijs FROM producten WHERE merk LIKE '%$zoek%'";
                $ostmt = $db->prepare($squery);
                $ostmt->bindvalue(':merk', '%$zoek%');
                $ostmt->execute();
                if($ostmt->rowcount()>0){
                    echo "<table>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>producten-id</th>";
                    echo "<th>artikel</th>";
                    echo "<th>merk</th>";
                    echo "<th>prijs</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                while($arow =$ostmt->fetch(PDO::FETCH_ASSOC)){
                    echo "<tr>";
                    echo "<td>" . $arow["productenid"] . "</td>";
                    echo "<td>" . $arow["artikel"] . "</td>";
                    echo "<td>" . $arow["merk"] . "</td>";
                    echo "<td>" . $arow["prijs"] . "</td>";
                    echo "</tr>";
                }
                    echo "</tbody>";
                    echo"</table>";
                }
                else{
                    echo "vul een merk in";
                }

            }
            catch(PDOException $e){
                die("Error!: " . $e->getMessage());
            }
        }
        $db = null;

?>

<main class="container text-warning">

</main>
    </body>
