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
        <?php
    require('submitS4.php');
    require('../connector.php'); 

    if(isset($_POST['submit'])) {
      register($_POST['username'], $_POST['score']);
    }
      
    if (isset($_POST['auslesen'])) {
      $db_res = runSQL("SELECT USERNAME, SCORE, DATE FROM s4 ORDER BY SCORE DESC LIMIT 7");
      
      echo('<table>');
      while($row = mysqli_fetch_array($db_res)) {
        echo('<tr>');
        echo('<td>' . $row['USERNAME'] . '</td>');
        echo('<td>' . $row['SCORE'] . '</td>');
        echo('<td>' . $row['DATE'] . '</td>');
        echo('</tr>');
      }
      echo('</table>');
           header("Location: index.php");
   exit();
    }

    if (isset($_POST['lookup'])) {
      $search = isset($_POST['search']) ? $_POST['search'] : '';

      global $db_link;
      $search = mysqli_real_escape_string($db_link, $search);

      if (empty($search)) {
        echo '<script type="text/javascript">alert("Zuerst einen Nutzernamen eingeben!");</script>';
      }

      else {
        $result = runSQL("SELECT COUNT(*) as count FROM S4 WHERE USERNAME = '$search'");
        $row = mysqli_fetch_assoc($result);

        $count = intval($row['count']);

        if ($count > 0) {
          $db_res = runSQL("SELECT USERNAME, SCORE, DATE FROM S4 WHERE USERNAME = '$search' ORDER BY SCORE DESC;");

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

        else {
          echo '<script type="text/javascript">alert("Dieser Nutzername existiert nicht!");</script>';
        }
      }
    }
  ?>

  <form action="index.php" method="POST">
    <label>Nutzernamen eingeben:</label>
    <input type="text" name="username" /> <br />
    <input type="hidden" name="score" id="hiddenScore" />
    <input type="submit" name="submit" value="Bestätigen" />
    <input type="submit" name="auslesen" value="Tabelle anzeigen" /> <br />
    <p>
    <label>Nach Nutzernamen suchen:</label>
    <input type="text" name="search" /> <br />
    <input type="submit" name="lookup" value="Nach Score suchen" /> <br />
  </form>
    </div>
</body>

</html>
