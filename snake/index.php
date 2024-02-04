<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spielewebsite - Snake</title>
    <style>
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #topleft {
            position: left;
        }

        #container {
            position: relative;
            text-align: center;
        }

        #gameCanvas {
            position: relative;
            z-index: 1; /* Ensure canvas is behind the form */
        }

        #tomjonathanform {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            display: none;
            
        }


        #start {
            top: 50%;
            left: 50%;
            transform: translate(33.3333%, 20%);
        }
        #scoreanzeige {
            display: inline;
            font-size: 20px;
        }
        
    </style>
</head>
<body style="font-family: 'Segoe UI', Arial, sans-serif;" >
    <?php
    require('submitS2.php');
    require('../connector.php'); 

    if(isset($_POST['submit'])) {

      register($_POST['username'], $_POST['score']);

    }
      
    if (isset($_POST['auslesen'])) {
        $db_res = runSQL("SELECT USERNAME, SCORE, DATE FROM s2 ORDER BY SCORE DESC");
        
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
  ?>
    <div id="topleft"></div>
    <div id="container">
        <div id="tomjonathanform">
            <form action="index.php" method="POST">
                <p>Herzlichen Glückwunsch</p>
                <p style="display: inline;">
                    <label>Du hast einen Score von</label>
                    <div id="loosescore" style="display: inline;"></div>
                    <label>erreicht!</label>
                </p>
                <p><label>Trage dich jetzt in die Highscoretabelle ein:</label></p>
                <label>Nutzernamen eingeben:</label>
                <input type="text" name="username" /> <br />
                <input type="hidden" name="score" id="hiddenScore"/>
                <input type="submit" name="submit" value="Bestätigen" />
                 <input type="submit" name="auslesen" value="Tabelle anzeigen" />
            </form>
            <button id="start">Erneut Spielen</button>
            <button id="probutton" onclick="toggleGrid()">Grid an/aus schalten</button>
        </div>
        <div id="scoreanzeige">
            <div>Score: </div>
            <div id="score">0</div>
        </div>
        <canvas id="gameCanvas" width="300" height="300"></canvas>
    </div>

    <script>

        //create canvas to draw game on
        var canvas = document.getElementById('gameCanvas');
        var ctx = canvas.getContext("2d");
        
        // Globale Variable, um den Gitterstatus zu speichern
        let isGridVisible = false;

        // Funktion zum Ein- und Ausschalten des Grids
        function toggleGrid() {
            isGridVisible = !isGridVisible;
            clearCanvas(); // Clear Canvas, um das Grid zu aktualisieren
        }

        // Funktion zum Zeichnen des Canvas mit oder ohne Grid
        function clearCanvas() {
            // Setze die Hintergrundfarbe auf Weiß
            ctx.fillStyle = "white";
            ctx.fillRect(0, 0, gameCanvas.width, gameCanvas.height);

            // Zeichne das Gitter, wenn isGridVisible true ist
            if (isGridVisible) {
                ctx.strokeStyle = 'black';
                ctx.lineWidth = 1;

                const gridSize = 10;

                // Zeichne vertikale Linien
                for (let x = 0; x <= gameCanvas.width; x += gridSize) {
                    ctx.beginPath();
                    ctx.moveTo(x, 0);
                    ctx.lineTo(x, gameCanvas.height);
                    ctx.stroke();
                }

                // Zeichne horizontale Linien
                for (let y = 0; y <= gameCanvas.height; y += gridSize) {
                    ctx.beginPath();
                    ctx.moveTo(0, y);
                    ctx.lineTo(gameCanvas.width, y);
                    ctx.stroke();
                }
            }

            // Zeichne den äußeren Rahmen
            ctx.strokeStyle = 'black';
            ctx.lineWidth = 2;
            ctx.strokeRect(0, 0, gameCanvas.width, gameCanvas.height);
        }



        //represent the snake
        let snake = [
            {x: 150, y: 150},
            {x: 140, y: 150},
            {x: 130, y: 150},
            {x: 120, y: 150},
            {x: 110, y: 150}
        ]
        let score = 0;

        //draw the snake (these functions get called every tick)
        function drawSnakePart(snakePart, fillcolor, strokecolor) {
            ctx.fillStyle = fillcolor;  
            ctx.strokestyle = strokecolor;
            ctx.lineWidth = 1;
            ctx.fillRect(snakePart.x, snakePart.y, 10, 10);  
            ctx.strokeRect(snakePart.x, snakePart.y, 10, 10);
        }
        function drawSnake(fillcolor = "lightgreen", strokecolor = "lightgreen") {
            snake.forEach(function(snakePart) {
                drawSnakePart(snakePart, fillcolor, strokecolor);
            });
        }
        //function  that changes dx and dy on button click (explained below)
        function changeDirection(event) {
            const LEFT_KEY = 37;
            const RIGHT_KEY = 39;
            const UP_KEY = 38;
            const DOWN_KEY = 40;

            if (changingDirection) return;
            changeDirection = true;

            const keyPressed = event.keyCode;
            const goingUp = dy === -10;
            const goingDown = dy === 10;
            const goingRight = dx === 10;
            const goingLeft = dx === -10;
            // Definiere die Tastencodes für WASD
            const W_KEY = 87;
            const A_KEY = 65;
            const S_KEY = 83;
            const D_KEY = 68;

            // Überprüfe die gedrückte Taste und aktualisiere die Geschwindigungsvektoren entsprechend
            if ((keyPressed === A_KEY || keyPressed === LEFT_KEY) && !goingRight) {
                dx = -10;
                dy = 0;
            }

            if ((keyPressed === W_KEY || keyPressed === UP_KEY) && !goingDown) {
                dx = 0;
                dy = -10;
            }

            if ((keyPressed === D_KEY || keyPressed === RIGHT_KEY) && !goingLeft) {
                dx = 10;
                dy = 0;
            }

            if ((keyPressed === S_KEY || keyPressed === DOWN_KEY) && !goingUp) {
                dx = 0;
                dy = 10;
            }

        }

        //variables which identify how much in which direction the snake 
        //should move on the next tick (get changed in changeDirection())
        let dx = 10;
        let dy = 0;

        function advanceSnake() {
            // Create the new Snake's head
            const head = {x: snake[0].x + dx, y: snake[0].y + dy};
            // Add the new head to the beginning of snake body
            snake.unshift(head);
            //remove last part of the snake
            const didEatFood = snake[0].x === foodX && snake[0].y === foodY;
            if (didEatFood) {
                score += 1;
                document.getElementById('score').innerHTML = score;
                createFood();
            } else {
                snake.pop();
            }
        }
        //create random numbers
        function randomTen(min, max) {
            return Math.round((Math.random() * (max-min) + min) / 10) * 10;
        }
        //create food (foodX and foodY)
        function createFood() {
            foodX = randomTen(0, gameCanvas.width - 10);
            foodY = randomTen(0, gameCanvas.height - 10);
            snake.forEach(function isFoodOnSnake(part) {
                const foodIsOnSnake = part.x == foodX && part.y == foodY
                if (foodIsOnSnake)
                createFood();
            });
        }
        //draw a food blob depending on foodX and foodY generated above
        function drawFood() {
            ctx.fillStyle = 'red';
            ctx.strokestyle = 'darkred';
            ctx.lineWidth = 1;
            ctx.fillRect(foodX, foodY, 10, 10);
            ctx.strokeRect(foodX, foodY, 10, 10);
        };
        
        //function that returns true if the snakes head is touching one of the walls or one of its bodyparts
        function didGameEnd() {
            //checks if snake touches its own body parts
            for (let i = 4; i < snake.length; i++) {
                const didCollide = snake[i].x === snake[0].x && snake[i].y === snake[0].y
                if (didCollide) return true
            };
            
            //checks if snake touches wall
            const hitLeftWall = snake[0].x < 0;
            const hitRightWall = snake[0].x > gameCanvas.width - 10;
            const hitToptWall = snake[0].y < 0;
            const hitBottomWall = snake[0].y > gameCanvas.height - 10;
            return  hitLeftWall || 
                    hitRightWall || 
                    hitToptWall ||
                    hitBottomWall
        };
        // ending animations of the game + forms and scores
        function gameEnd() {
            // snake dies
            drawSnake("red", "red")
            x = 0;
            
            function blacksnake() {
                setTimeout(function onTick() {
                    drawSnakePart(snake[x], "black", "black");
                    x += 1;

                    if (snake.length == x) gameEnd2();
                    else {
                        blacksnake()
                    };
                }, 1200/snake.length);
            };
            
            function gameEnd2(){
                // fades out the canvas
                var opacity = 1;
                var intervalId = setInterval(function() {
                    if (opacity > 0) {
                        opacity -= 0.02; // Adjust the decrement value for speed
                        canvas.style.opacity = opacity;
                    } 
                    else {
                        clearInterval(intervalId);
                        canvas.style.display = "none"; // Hide the canvas when it's completely faded
                        
                        // forms and score get projected
                        document.getElementById("hiddenScore").value = score;
                        document.getElementById("tomjonathanform").style.display = "block";
                        document.getElementById("start").style.display = "block";
                        document.getElementById("scoreanzeige").style.display = "none";
                        document.getElementById("loosescore").innerHTML = score;
                        score = 0;
                    }
                }, 10); // Adjust the interval for smoothness
            }

            
            blacksnake();
        };

        function main() {
            if (didGameEnd()){
                gameEnd()
                return
            };
            setTimeout(function onTick() {
                changingDirection = false;
                clearCanvas();
                drawFood()
                advanceSnake();
                drawSnake();                
                // Call main again
                main();
            }, 100)
        }
        createFood()
        main()
        document.addEventListener("keydown", changeDirection)

        // Warten, bis das DOM vollständig geladen ist
        document.addEventListener("DOMContentLoaded", function() {


            var button = document.getElementById("start");

            // Event-Listener für den Klick auf den Button hinzufügen
            button.addEventListener("click", function() {
                // Die Funktion, die beim Klicken auf den Button ausgeführt wird
                //represent the snake
                snake = [
                    {x: 150, y: 150},
                    {x: 140, y: 150},
                    {x: 130, y: 150},
                    {x: 120, y: 150},
                    {x: 110, y: 150}
                ]
                let score = 0;
                document.getElementById('score').innerHTML = 0;
                canvas.style.opacity = 1;
                canvas.style.display = "block";
                document.getElementById("tomjonathanform").style.display = "none";
                document.getElementById("scoreanzeige").style.display = "block";
                dx = 10;
                dy = 0;
                
                main();
            });
        });
    </script>
</body>
</html>
