<?php

if (!function_exists('runSQL')) {

    $db_link = mysqli_connect('mariadb', 'root', '8hHLM6y#2UqJ6N' , 'informatikhighscores','3306');

    if (!$db_link) {

        die("<p>Verbindung nicht hergestellt! Fehler: " . mysqli_connect_error() . "</p>");

    }

    function runSQL($sql) {

        global $db_link;
        
        $db_res = mysqli_query($db_link, $sql) or die("SQL-Abfrage: " . $sql . ", Fehler: " . mysqli_error($db_link));

        return $db_res;
    }
}
?>
