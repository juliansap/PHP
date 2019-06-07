<!DOCTYPE html>
<html>
<head>
      <link rel="stylesheet" type="text/css" href="rekenmachinecss.css">
    <title>rekenmachine </title>
</head>
<body>

<?php
include 'rekenopdrachtnav.html';
?>
    
    <?php
if(isset($_POST['plus'])) {
   if (is_numeric($_POST['nummerx']) &&  is_numeric($_POST['nummery'])) {
        $x = $_POST['nummerx'];
        $y = $_POST['nummery'];
        $ant = $x + $y;
        
    echo "$ant";
    }
    else {
        echo"vul beide invoer velden in";
    }
}


if(isset($_POST['min'])) {
   if (is_numeric($_POST['nummerx']) &&  is_numeric($_POST['nummery'])) {
        $x = $_POST['nummerx'];
        $y = $_POST['nummery'];
        $ant = $x - $y;
        
    echo "$ant";
    }
    else {
        echo"vul beide invoer velden in";
    }
}


if(isset($_POST['delendoor'])) {
   if (is_numeric($_POST['nummerx']) &&  is_numeric($_POST['nummery'])) {
       if ($_POST['nummery']==0) {
           echo "delen door nul is niet toegestaan";
       } else {
        $x = $_POST['nummerx'];
        $y = $_POST['nummery'];
        $ant = $x / $y;
        
    echo "$ant";
       }
    }
    else {
        echo"vul beide invoer velden in";
    }
}


if(isset($_POST['keer'])) {
   if (is_numeric($_POST['nummerx']) &&  is_numeric($_POST['nummery'])) {
        $x = $_POST['nummerx'];
        $y = $_POST['nummery'];
        $ant = $x * $y;
        
    echo "$ant";
    }
    else {
        echo"vul beide invoer velden in";
    }
}
   
if(isset($_POST['kwadraat'])) {
   if (is_numeric($_POST['nummerx']) &&  empty($_POST['nummery'])) {
       $x = $_POST['nummerx'];
       $ant = pow($x,2);
       
    echo "$ant";
   }  
    else {
        echo"vul aleen het bovenste invulveld in";
    }
}

if(isset($_POST['wortel'])) {
   if (is_numeric($_POST['nummerx']) &&  empty($_POST['nummery'])) {
       $x = $_POST['nummerx'];
       $ant = pow($x, 1/2);
       
    echo "$ant";
   }  
    else {
        echo"vul aleen het bovenste invulveld in";
    }
}
    
    if(isset($_POST['tafel'])) {
   if (is_numeric($_POST['nummerx']) &&  empty($_POST['nummery'])) {
       $x = $_POST['nummerx'];
    echo "de tafel van: $x <br>";
    for($i=1;$i<=10;$i++){
        
        $ant = $x * $i;
       
    echo "$x x $i = $ant <br>";
    }
   }  
    else {
        echo"vul aleen het bovenste invulveld in";
    }
}
    
if(isset($_POST['macht'])) {
   if (is_numeric($_POST['nummerx']) &&  is_numeric($_POST['nummery'])) {
       $x = $_POST['nummerx'];
       $y = $_POST['nummery'];
       $ant = pow($x,$y);
       
    echo "$ant";
   }  
    else {
        echo"vul beiden invul velden in";
    }
}    
    
?>
    
<section>
<form action="rekenmachine.php" method="post">
<input type="number" name="nummerx" step="any">
    <br><br>
<input type="number" name="nummery" step="any">
    <br><br>
    <br><br>
<button type="submit" name="plus">plus</button>
<button type="submit" name="min">min</button>
<button type="submit" name="delendoor">delen</button>
    <br>
<button type="submit" name="keer">keer</button>
<button type="submit" name="kwadraat">kwadraat</button>
<button type="submit" name="wortel">wortel</button>
    <br>
<button type="submit" name="tafel">tafel</button>
<button type="submit" name="macht">macht</button> 
<button class="apart" type="submit" name="reset">reset</button>
    <br>



</form>    
</section>
    

</body>
</html>
