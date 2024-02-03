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
        <form action="submitS4.php" method="POST">
            <label>Enter your username:</label>
            <input type="text" name="username" />
            <input type="hidden" name="score" id="hiddenScore" />
            <input type="submit" name="submit" value="Submit Score" />
        </form>
    </div>
</body>
</html>
