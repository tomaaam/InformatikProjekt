<?php
// Include the connector.php file
include '../connector.php';

// Function to retrieve top 5 scores from a specific game
function getTopScores($game, $db_link) {
    $sql = "SELECT USERNAME, SCORE FROM $game ORDER BY SCORE DESC LIMIT 5";
    $result = mysqli_query($db_link, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Display top 5 scores for a specific game
if(isset($_GET['game'])) {
    $game = $_GET['game'];
    $scores = getTopScores($game, $db_link);
    if (count($scores) > 0) {
        echo "<table id='$game'>";
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
        echo "<p>No scores yet for Game $game</p>";
    }
    exit; // Stop execution after fetching scores
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Scores</title>
    <style>
        /* CSS styles for the table layout */
        .container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 10px;
            max-width: 800px; /* Limit maximum container width */
            margin: 0 auto;
        }
        table {
            border-collapse: collapse;
            width: 100%; /* Set table width to 100% of container */
            font-size: 1.2em; /* Set default font size */
        }
        th, td {
            border: 1px solid #bbb;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Highscores</h2>

<!-- Container to arrange tables -->
<div class="container">
    <?php
    // Display top 5 scores for each game
    $games = array(
        "Blockjumpinggame" => "s1" => "Top 5 Scores for Blockjumpinggame",
        "Snake" => "s2" => "Top 5 Scores for Snake",
        "Tetris" => "s5" => "Top 5 Scores for Tetris",
        "NewGame" => "s4" => "Top 5 Scores for NewGame" // Add new game
    );

    foreach ($games as $gameName => $gameTable => $heading) {
        echo "<div id='$gameTable'>";
        echo "<h3>$heading</h3>"; // Add headline for each table
        echo "</div>";
    }
    ?>
</div>

<script>
// Function to update scores every 15 seconds
function updateScores() {
    <?php
    // Refresh scores for each game
    foreach ($games as $gameName => $gameTable) {
        echo "fetchScores('$gameTable');";
    }
    ?>
}

// Function to fetch scores using AJAX
function fetchScores(game) {
    fetch('index.php?game=' + game)
        .then(response => response.text())
        .then(data => {
            document.getElementById(game).innerHTML = data;
        });
}

// Call updateScores function every 5 seconds
setInterval(updateScores, 5000);

// Initial call to update scores
updateScores();
</script>

</body>
</html>
