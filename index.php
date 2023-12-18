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

  <p>Highscore: <span id="highscore"></span></p>
  <button onclick=generateTestscore()>Highscore generieren</button>

  <?php
    require('submitusername.php');
    require('connector.php'); 

    if(isset($_POST['submit'])) {

      register($_POST['username'], $_POST['score']);

    }
      
    if (isset($_POST['auslesen'])) {
        
      $db_res = runSQL("SELECT USERNAME, SCORE, DATE FROM S1");
      
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
  ?>

  <form action="index.php" method="POST">
    <label>Nutzernamen eingeben:</label>
    <input type="text" name="username" /> <br />
    <input type="hidden" name="score" id="hiddenScore" />
    <input type="submit" name="submit" value="Bestätigen" />
    <input type="submit" name="auslesen" value="Tabelle anzeigen" />
  </form>

  <!--

  <div id = "button">
    <button type="button" onclick = "writeName()">Namen ändern</button>
    <button type="button" onclick = "writeScore()">Score ändern</button>
  </div>

  
    <script>
    function writeName() {
      console.log("S1_name.txt file has been successfully updated")
      const xhttp = new XMLHttpRequest();
      xhttp.open("GET", "phpsheetUSERNAME.php", true);
      xhttp.send();
    }
    
    function writeScore() {
      console.log("S1_score.txt file has been successfully updated")
      const xhttp = new XMLHttpRequest();
      xhttp.open("GET", "phpsheetSCORE.php", true);
      xhttp.send();
    }
  </script>
  -->
</body>
</html>
