<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2048</title>
    <link rel="stylesheet" href="2048.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
        <div id="tableContainer"></div> <!-- Container for the table -->
        <form action="index.php" method="POST">
            <label>Nutzernamen eingeben:</label>
            <input type="text" name="username" /> <br />
            <input type="hidden" name="score" id="hiddenScore" />
            <input type="submit" name="submit" value="Bestätigen" />
            <input type="button" id="showTable" value="Tabelle anzeigen" /> <br />
            <p>
            <label>Nach Nutzernamen suchen:</label>
            <input type="text" name="search" /> <br />
            <input type="submit" name="lookup" value="Nach Score suchen" /> <br />
        </form>
    </div>
</body>

<script>
    $('form').submit(function(event) {
        event.preventDefault(); // Prevent the form from being submitted the traditional way
    
        var username = $('input[name="username"]').val(); // Get the username from the input field
        var score = $('#finalScore').text(); // Get the final score from the span
    
        $.ajax({
            url: 'submitS4.php', // The URL of the PHP file that handles the data
            type: 'POST', // The HTTP method to use
            data: { // The data to send to the server
                'username': username,
                'score': score
            },
            success: function(data) {
                console.log('Success:', data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error:', textStatus, errorThrown);
            }
        });
    });
</script>

</html>
