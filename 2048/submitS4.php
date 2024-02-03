<?php

    function register($username, $score) {
    global $db_link;
    
    $username = mysqli_real_escape_string($db_link, $username);
    $score = mysqli_real_escape_string($db_link, $score);

    if (empty($username)) {
        runSQL("INSERT INTO s4 (USERNAME, SCORE) VALUES ('Anonym', '$score')");
    } else {
        runSQL("INSERT INTO s4 (USERNAME, SCORE) VALUES ('$username', '$score')");
    }

    // Redirect to a new page after form submission
    header("Location: success.php"); // Replace "success.php" with the actual page you want to redirect to
    exit();
}
?>
