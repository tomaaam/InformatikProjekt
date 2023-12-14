<?php

    function register($username, $score) {
        
        echo('<p>Erfolgreich!</p>');
            
        global $db_link;
        $username = mysqli_real_escape_string($db_link, $username);
        $score = mysqli_real_escape_string($db_link, $score);

        runSQL("INSERT INTO s1 (USERNAME, SCORE) VALUES ('" . $username . "' , '" . $score . "')");
    }
?>