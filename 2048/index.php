<?php
require('../connector.php');

if (isset($_POST['submit'])) {
    register($_POST['username'], $_POST['score']);
} elseif (isset($_POST['auslesen'])) {
    displayTopScores();
} elseif (isset($_POST['lookup'])) {
    $search = isset($_POST['search']) ? $_POST['search'] : '';

    global $db_link;
    $search = mysqli_real_escape_string($db_link, $search);

    if (empty($search)) {
        echo '<script type="text/javascript">alert("Zuerst einen Nutzernamen eingeben!");</script>';
    } else {
        searchUserScores($search);
    }
}

function register($username, $score)
{
    global $db_link;

    $username = mysqli_real_escape_string($db_link, $username);
    $score = mysqli_real_escape_string($db_link, $score);

    if (empty($username)) {
        $username = "Anonym";
    }

    $query = "INSERT INTO s4 (USERNAME, SCORE) VALUES ('$username', '$score')";
    runSQL($query);

    echo '<p>Erfolgreich!</p>';
    header("Location: index.php");
    exit();
}

function displayTopScores()
{
    $db_res = runSQL("SELECT USERNAME, SCORE, DATE FROM s4 ORDER BY SCORE DESC");

    echo('<table>');
    while ($row = mysqli_fetch_array($db_res)) {
        echo('<tr>');
        echo('<td>' . $row['USERNAME'] . '</td>');
        echo('<td>' . $row['SCORE'] . '</td>');
        echo('<td>' . $row['DATE'] . '</td>');
        echo('</tr>');
    }
    echo('</table>');

    // Redirect back to index.php after displaying top scores
    header("Location: index.php");
    exit();
}

function searchUserScores($username)
{
    global $db_link;

    $result = runSQL("SELECT COUNT(*) as count FROM s4 WHERE USERNAME = '$username'");
    $row = mysqli_fetch_assoc($result);
    $count = intval($row['count']);

    if ($count > 0) {
        $db_res = runSQL("SELECT USERNAME, SCORE, DATE FROM s4 WHERE USERNAME = '$username' ORDER BY SCORE DESC;");

        echo('<table>');
        while ($row = mysqli_fetch_array($db_res)) {
            echo('<tr>');
            echo('<td>' . $row['USERNAME'] . '</td>');
            echo('<td>' . $row['SCORE'] . '</td>');
            echo('<td>' . $row['DATE'] . '</td>');
            echo('</tr>');
        }
        echo('</table>');
    } else {
        echo '<script type="text/javascript">alert("Dieser Nutzername existiert nicht!");</script>';
    }

    // Redirect back to index.php after searching user scores
    header("Location: index.php");
    exit();
    echo('<p>Erfolgreich!</p>');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>2048</title>
        <link rel="stylesheet" href="2048.css">
        <script src="2048.js"></script>
    </head>

    <body>
    <h1>2048</h1>
    <hr>
    <h2>Score: <span id="score">0</span></h2>
    <div id="board"></div>

    <!-- New end screen div -->
    <div id="endScreen" style="display: none;">
        <h3>Game Over!</h3>
        <p>Your score: <span id="finalScore">0</span></p>
        <form action="index.php" method="POST">
            <label>Enter your username:</label>
            <input type="text" name="username" />
            <input type="hidden" name="score" id="hiddenScore" />
            <input type="submit" name="submit" value="Submit Score" />
        </form>
    </div>
</body>
</html>
