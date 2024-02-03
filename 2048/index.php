<?php
    require('submitS4.php');
    require('../connector.php'); 

    if(isset($_POST['submit'])) {
      register($_POST['username'], $_POST['score']);
    }
      
    if (isset($_POST['auslesen'])) {
      // Display top scores
      displayTopScores();
    }

    if (isset($_POST['lookup'])) {
      $search = isset($_POST['search']) ? $_POST['search'] : '';

      global $db_link;
      $search = mysqli_real_escape_string($db_link, $search);

      if (empty($search)) {
        echo '<script type="text/javascript">alert("Zuerst einen Nutzernamen eingeben!");</script>';
      } else {
        searchUserScores($search);
        header("Location: index.php");
        exit();
      }
    }

    function displayTopScores() {
      $db_res = runSQL("SELECT USERNAME, SCORE, DATE FROM s5 ORDER BY SCORE DESC");
      
      echo('<table>');
      while($row = mysqli_fetch_array($db_res)) {
        echo('<tr>');
        echo('<td>' . $row['USERNAME'] . '</td>');
        echo('<td>' . $row['SCORE'] . '</td>');
        echo('<td>' . $row['DATE'] . '</td>');
        echo('</tr>');
      }
      echo('</table>');
    }

    function searchUserScores($username) {
      global $db_link;

      $result = runSQL("SELECT COUNT(*) as count FROM s5 WHERE USERNAME = '$username'");
      $row = mysqli_fetch_assoc($result);
      $count = intval($row['count']);

      if ($count > 0) {
        $db_res = runSQL("SELECT USERNAME, SCORE, DATE FROM s5 WHERE USERNAME = '$username' ORDER BY SCORE DESC;");

        echo('<table>');
        while($row = mysqli_fetch_array($db_res)) {
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
