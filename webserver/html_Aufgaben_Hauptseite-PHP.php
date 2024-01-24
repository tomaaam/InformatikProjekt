<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kein Virus</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            height: 100vh;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #2a752c;
            margin-top: 20px;
        }
        .container {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            justify-content: center;
            margin-top: 20px;
        }
        .games-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-right: 20px;
        }
        .game-button {
            margin: 10px;
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        table {
            border-collapse: collapse;
            width: 50%;
            border: 1px solid #ccc;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 10px;
        }
    </style>
</head>
<body>
    <center>
        <h1>Wilkommen auf der Spielseite</h1>
        <div class="container">
            <div class="games-container">
                <div class="grid-container">
                    <button class="game-button" onclick="alert('Sie haben Feld 1 ausgewählt.')">
                        <img src="https://res.cloudinary.com/dk-find-out/image/upload/q_80,w_1920,f_auto/DCTM_Penguin_UK_DK_AL629526_pkusmj.jpg" width="50%" alt="Spiel 1">
                    </button>
                    <button class="game-button" onclick="alert('Sie haben Feld 2 ausgewählt.')">
                        <img src="https://static.wikia.nocookie.net/board-game-art/images/2/2c/Hangmanlogo.png/revision/latest?cb=20220905032055" width="50%" alt="Spiel 2">
                    </button>
                    <button class="game-button" onclick="alert('Sie haben Feld 3 ausgewählt.')">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/18/2048_logo.svg/800px-2048_logo.svg.png" width="50%" alt="Spiel 3">
                    </button>
                    <button class="game-button" onclick="alert('Sie haben Feld 4 ausgewählt.')">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSNeC_kdZj71WtnVrvp_XIvV71HjuT0Jnh_gg&usqp=CAU" width="50%" alt="Spiel 4">
                    <button class="game-button" onclick="alert('Tik Tak Toe')">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/7/7d/Super_tic-tac-toe_rules_example.png" width="50%" alt="Spiel 5">
                    <button class="game-button" onclick="alert('Tetris')">
                        <img src="" width="50%" alt="Spiel 6"
                    <!-- Weitere Buttons hier hinzufügen -->
        </center>
  <form action="html_Aufgabe_Hauptseite-PHP.php" method="POST">
    <input type="submit" name="auslesen" value="Tabelle anzeigen" /> <br />
  </form>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>snake</th>
                        <th>Hang man</th>
                        <th>2048</th>
                        <th>Tetris</th>
                        <th>Tic tac to</th>
                        <th>Spalte 6</th>
                        <th>      </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Zeile 1</td>
                        <td>Zeile 1</td>
                        <td>Zeile 1</td>
                        <td>Zeile 1</td>
                        <td>Zeile 1</td>
                        <td>Zeile 1</td>
                        <td>Spieler</td>
                    </tr>
                    <tr>
                        <td>Zeile 2</td>
                        <td>Zeile 2</td>
                        <td>Zeile 2</td>
                        <td>Zeile 1</td>
                        <td>Zeile 1</td>
                        <td>Zeile 1</td>
                    </tr>
                    <tr>
                        <td>Zeile 15</td>
                        <td>Zeile 15</td>
                        <td>Zeile 15</td>
                        <td>Zeile 15</td>
                        <td>Zeile 15</td>
                        <td>Zeile 15</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </center>
</body>
</html>
