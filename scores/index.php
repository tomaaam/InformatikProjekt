<?php
// Include the connector.php file
include '../connector.php';

// Function to retrieve top 5 scores from a specific game
function getTopScores($game, $db_link) {
    $sql = "SELECT USERNAME, SCORE FROM $game ORDER BY SCORE DESC LIMIT 3";
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
        <style>
            table {
                border-collapse: collapse;
                width: 90%; /* Set table width to 90% of the screen width */
                max-width: 800px; /* Limit maximum table width to 800px */
                margin: 0 auto;
                font-size: 1.2em; /* Set default font size */
                max-height: 90vh; /* Limit maximum table height to 90% of the viewport height */
                overflow-y: auto; /* Add vertical scrollbar if the table exceeds the viewport height */
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

<?php
// Display top 5 scores for each game
$games = array(
    "Blockjumpinggame" => "s1",
    "Snake" => "s2",
    "Tetris" => "s5"
);

foreach ($games as $gameName => $gameTable) {
    echo "<h3>Top 3 Scores for $gameName</h3>";
    echo "<div id='$gameTable'></div>";
}
?>

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
