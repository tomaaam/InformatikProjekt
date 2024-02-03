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

        <!-- Integrated PHP code for s4 database and submitS4 function -->
        <?php
        require('../connector.php'); // Adjust the path to connector.php
        require('submitS4.php'); // Assuming you have a file named submitS4.php

        if (isset($_POST['submit'])) {
            submitS4($_POST['username'], $_POST['score']); // Change to submitS4
        }

        if (isset($_POST['auslesen'])) {
            $db_res = runSQL("SELECT USERNAME, SCORE, DATE FROM s4 ORDER BY SCORE DESC"); // Change to s4

            echo('<table>');
            while ($row = mysqli_fetch_array($db_res)) {
                echo('<tr>');
                echo('<td>' . $row['USERNAME'] . '</td>');
                echo('<td>' . $row['SCORE'] . '</td>');
                echo('<td>' . $row['DATE'] . '</td>');
                echo('</tr>');
            }
            echo('</table>');
        }

        if (isset($_POST['lookup'])) {
            $search = isset($_POST['search']) ? $_POST['search'] : '';

            global $db_link;
            $search = mysqli_real_escape_string($db_link, $search);

            if (empty($search)) {
                echo '<script type="text/javascript">alert("Zuerst einen Nutzernamen eingeben!");</script>';
            } else {
                $result = runSQL("SELECT COUNT(*) as count FROM s4 WHERE USERNAME = '$search'"); // Change to s4
                $row = mysqli_fetch_assoc($result);

                $count = intval($row['count']);

                if ($count > 0) {
                    $db_res = runSQL("SELECT USERNAME, SCORE, DATE FROM s4 WHERE USERNAME = '$search' ORDER BY SCORE DESC;"); // Change to s4

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
            }
        }
        ?>
        <!-- End of integrated PHP code -->

        <!-- Form handling with JavaScript -->
        <form id="scoreForm">
            <label>Enter your username:</label>
            <input type="text" name="username" />
            <input type="hidden" name="score" id="hiddenScore" />
            <input type="submit" name="submit" value="Submit Score" />
        </form>

        <script>
            document.getElementById('scoreForm').addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission

                // AJAX/fetch code to submit the form data to submitS4.php
                // ...

                // Assume the JSON response from submitS4.php is stored in response variable
                const response = { success: true }; // Replace with actual response

                if (response.success) {
                    // Redirect to a new page after form submission
                    window.location.href = 'success.php'; // Replace "success.php" with the actual page you want to redirect to
                }
            });
        </script>
    </div>
</body>

</html>
