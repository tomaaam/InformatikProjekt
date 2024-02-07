<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Scores</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Top 5 Scores for Each Game</h2>

<?php
// Include the database connector file
include '../connector.php';

// Function to retrieve top 5 scores from a specific game
function getTopScores($game) {
    global $db_link;
    $sql = "SELECT USERNAME, SCORE FROM $game ORDER BY SCORE DESC LIMIT 5";
    $result = mysqli_query($db_link, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Game names
$gameNames = [
    's1' => 'Blockjumpinggame',
    's2' => 'Snake',
    's5' => 'Tetris'
];

// Display top 5 scores for each game
foreach ($gameNames as $game => $gameName) {
    $scores = getTopScores($game);
    echo "<h3>Top 5 Scores for $gameName</h3>";
    if (count($scores) > 0) {
        echo "<table>";
        echo "<tr><th>Rank</th><th>Username</th><th>Score</th></tr>";
        $rank = 1;
        foreach ($scores as $score) {
            echo "<tr>";
            echo "<td>$rank</td>";
            echo "<td>{$score['USERNAME']}</td>";
            echo "<td>{$score['SCORE']}</td>";
            echo "</tr>";
            $rank++;
        }
        echo "</table>";
    } else {
        echo "<p>No scores yet for $gameName</p>";
    }
}

// Close database connection (optional)
mysqli_close($db_link);
?>

</body>
</html>
