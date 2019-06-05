<?php
try
{
    $db = new PDO('mysql:host=localhost;dbname=dumas3', 'root' ,'');
}
catch(PDOException $e)
{
    $sMsg = '<p>
            Regelnummer: '.$e->getLine().'<br />
            Bestand: '.$e->getFile().'<br /> 
            Foutmelding: '.$e->getMessage().'
        </p>';

    trigger_error($sMsg);
}
?>
