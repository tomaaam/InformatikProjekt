<?php
// getTopScores.php

require('connector.php');

function getTopScores() {
    global $db_link;

    if (!$db_link) {
        die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . mysqli_connect_error()]));
    }

    $query = "SELECT * FROM s1 ORDER BY SCORE DESC LIMIT 10";
    $result = runSQL($query);

    if (!$result) {
        die(json_encode(['status' => 'error', 'message' => 'Database error: ' . mysqli_error($db_link)]));
    }

    $topScores = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $topScores[] = ['username' => $row['USERNAME'], 'score' => $row['SCORE']];
    }

    echo json_encode(['status' => 'success', 'topScores' => $topScores]);
}

getTopScores();
?>
