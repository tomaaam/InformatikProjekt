<?php

    function register($username, $score) {
        
        echo('<p>Erfolgreich!</p>');
            
        global $db_link;
        $username = mysqli_real_escape_string($db_link, $username);
        $score = mysqli_real_escape_string($db_link, $score);

        if (empty($username)) {
            runSQL("INSERT INTO s6 (USERNAME, SCORE) VALUES ('" . "Anonym" . "' , '" . $score . "')");
        }

        else {
        runSQL("INSERT INTO s6 (USERNAME, SCORE) VALUES ('" . $username . "' , '" . $score . "')");
        }    
    }
?>
