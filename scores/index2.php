<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Scores</title>
    <style>
        .outer-table {
            border-collapse: collapse;
            width: 100%;
            margin: 0 auto;
            border: 2px solid #bbb; /* Outer table border color */
        }
        .inner-table {
            border-collapse: collapse;
            width: 50%;
            margin: 0 auto;
        }
        th, td {
            border: 1px solid #bbb; /* Inner table border color */
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Top 10 Scores for Each Game</h2>

<?php
// Include the connector.php file
include '../connector.php';

// Function to retrieve top 10 scores from a specific game
function getTopScores($game, $db_link) {
    $sql = "SELECT USERNAME, SCORE FROM $game ORDER BY SCORE DESC LIMIT 10";
    $result = mysqli_query($db_link, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Display top 10 scores for each game
$games = array(
    "Game 1" => "s1",
    "Game 2" => "s2",
    "Game 3" => "s5"
);

foreach ($games as $gameName => $gameTable) {
    echo "<h3>Top 10 Scores for $gameName</h3>";
    echo "<table class='outer-table'><tr><td>";
    $scores = getTopScores($gameTable, $db_link);
    if (count($scores) > 0) {
        echo "<table class='inner-table'>";
        echo "<tr><th>Rank</th><th>Username</th><th>Score</th></tr>";
        $rank = 1;
        foreach ($scores as $score) {
            if ($rank == 6) { // Start the second table after 5 scores
                echo "</table></td><td><table class='inner-table'>";
                echo "<tr><th>Rank</th><th>Username</th><th>Score</th></tr>";
            }
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
    echo "</td></tr></table>";
}
?>

</body>
</html>
