<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testumgebung</title>
    <script>
      function generateTestscore() {
        var score = Math.floor(Math.random() * 10000);
        document.getElementById("highscore").innerHTML = score;
        document.getElementById("hiddenScore").value = score;
      }
    </script>
</head>
<body>

  Highscore: <span id="highscore"></span><br />
  <button onclick=generateTestscore()>Highscore generieren</button>
  <p>

  <?php
    require('submitS1.php');
    require('connector.php'); 

    if(isset($_POST['submit'])) {
      register($_POST['username'], $_POST['score']);
    }
      
    if (isset($_POST['auslesen'])) {
      $db_res = runSQL("SELECT USERNAME, SCORE, DATE FROM s1 ORDER BY SCORE DESC");
      
      echo('<table>');
      while($row = mysqli_fetch_array($db_res) AND $i<=10) {
        echo('<tr>');
        echo('<td>' . $row['USERNAME'] . '</td>');
        echo('<td>' . $row['SCORE'] . '</td>');
        echo('<td>' . $row['DATE'] . '</td>');
        echo('</tr>');
        $i++;
      }
      echo('</table>');
    }

    if (isset($_POST['lookup'])) {
      $search = isset($_POST['search']) ? $_POST['search'] : '';

      global $db_link;
      $search = mysqli_real_escape_string($db_link, $search);

      if (empty($search)) {
        echo '<script type="text/javascript">alert("Zuerst einen Nutzernamen eingeben!");</script>';
      }

      else {
        $result = runSQL("SELECT COUNT(*) as count FROM S1 WHERE USERNAME = '$search'");
        $row = mysqli_fetch_assoc($result);

        $count = intval($row['count']);

        if ($count > 0) {
          $db_res = runSQL("SELECT USERNAME, SCORE, DATE FROM S1 WHERE USERNAME = '$search' ORDER BY SCORE DESC;");

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
    
</body>
</html>
