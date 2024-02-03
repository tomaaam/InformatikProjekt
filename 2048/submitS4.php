<?php

function submitS4($username, $score) {
    global $db_link;
    
    $username = mysqli_real_escape_string($db_link, $username);
    $score = mysqli_real_escape_string($db_link, $score);

    if (empty($username)) {
        runSQL("INSERT INTO s4 (USERNAME, SCORE) VALUES ('Anonym', '$score')");
    } else {
        runSQL("INSERT INTO s4 (USERNAME, SCORE) VALUES ('$username', '$score')");
    }

    // Send a JSON response indicating success
    echo json_encode(['success' => true]);
    exit();
}

// Additional functions or code related to submitS4.php

?>
