<?php
    $db_link = mysqli_connect('mysql', 'root', 'wobo2024' , 'informatikhighscores','3306');

    if (!$db_link) {

        die("<p>Verbindung nicht hergestellt!</p>");
    
    }

    function runSQL($sql) {

        global $db_link;
        
        $db_res = mysqli_query($db_link, $sql) or die("SQL-Abfrage: " . $sql . ", Fehler: " . mysqli_error($db_link));

        return $db_res;
    }
?>
