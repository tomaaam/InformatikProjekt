<?php
// submitS1.php

require('connector.php');

function register($username, $score) {
    global $db_link;

    // Check if $db_link is set
    if (!$db_link) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    $username = mysqli_real_escape_string($db_link, $username);
    $score = mysqli_real_escape_string($db_link, $score);

    if (empty($username)) {
        $query = "INSERT INTO s1 (USERNAME, SCORE) VALUES ('Anonym', '$score')";
    } else {
        $query = "INSERT INTO s1 (USERNAME, SCORE) VALUES ('$username', '$score')";
    }

    $result = runSQL($query);

    if (!$result) {
        echo json_encode(array('status' => 'error', 'message' => mysqli_error($db_link)));
    } else {
        echo json_encode(array('status' => 'success', 'message' => 'Erfolgreich!'));
    }
}

if (isset($_POST['submit'])) {
    register($_POST['username'], $_POST['score']);
}
?>