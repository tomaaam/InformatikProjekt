<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testumgebung</title>
    <script>
      function generateTestscore() { //Generierung eines beispielhaften Highscores, ersetzt eure Definition eines "echten" Highscores zu Testzwecken
        var score = Math.floor(Math.random() * 10000);
        document.getElementById("highscore").innerHTML = score;
        document.getElementById("hiddenScore").value = score; //Der Highscore wird in das "versteckte" Objekt geschrieben  
      }
    </script>
</head>
<body>

  <p>Highscore: <span id="highscore"></span></p>
  <button onclick=generateTestscore()>Highscore generieren</button>

  <?php
    require('submitS1.php'); //HIER MUSS "S1" durch euren Teil ersetzt werden! (siehe "README.md")
    require('connector.php'); //Hier muss nichts geändert werden

    if(isset($_POST['submit'])) { 

      register($_POST['username'], $_POST['score']); //Sendung von Daten an die Datenbank über die jeweilige "submitS[].php"-Datei

    }
      
    if (isset($_POST['auslesen'])) {
        
      $db_res = runSQL("SELECT USERNAME, SCORE, DATE FROM S1 ORDER BY SCORE DESC"); //Empfanh von Daten aus der Datenbank
      
      echo('<table>'); //Ausgabe der Daten als unformatierte Tabelle
      while($row = mysqli_fetch_array($db_res)) {
        echo('<tr>');
        echo('<td>' . $row['USERNAME'] . '</td>');
        echo('<td>' . $row['SCORE'] . '</td>');
        echo('<td>' . $row['DATE'] . '</td>');
        echo('</tr>');
      }
      echo('</table>');
    }
  ?>

  <form action="index.php" method="POST">
    <label>Nutzernamen eingeben:</label>
    <input type="text" name="username" /> <br />
    <input type="hidden" name="score" id="hiddenScore" />
    <input type="submit" name="submit" value="Bestätigen" />
    <input type="submit" name="auslesen" value="Tabelle anzeigen" />
  </form>
    
</body>
</html>
