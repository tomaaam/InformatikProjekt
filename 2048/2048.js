var board;
var score = 0;
var rows = 4;
var columns = 4;

window.onload = function() {
    setGame();
}

function setGame() {
    // board = [
    //     [2, 2, 2, 2],
    //     [2, 2, 2, 2],
    //     [4, 4, 8, 8],
    //     [4, 4, 8, 8]
    // ];

    board = [
        [0, 0, 0, 0],
        [0, 0, 0, 0],
        [0, 0, 0, 0],
        [0, 0, 0, 0]
    ]

    for (let r = 0; r < rows; r++) {
        for (let c = 0; c < columns; c++) {
            let tile = document.createElement("div");
            tile.id = r.toString() + "-" + c.toString();
            let num = board[r][c];
            updateTile(tile, num);
            document.getElementById("board").append(tile);
        }
    }
    //create 2 to begin the game
    setTwo();
    setTwo();

}

function updateTile(tile, num) {
    tile.innerText = "";
    tile.classList.value = ""; //clear the classList
    tile.classList.add("tile");
    if (num > 0) {
        tile.innerText = num.toString();
        if (num <= 4096) {
            tile.classList.add("x"+num.toString());
        } else {
            tile.classList.add("x8192");
        }                
    }
}

document.addEventListener('keyup', (e) => {
    if (isGameOver()) {
        showGameOverScreen();
        return;
    }
    if (e.code == "ArrowLeft") {
        slideLeft();
        setTwo();
    }
    else if (e.code == "ArrowRight") {
        slideRight();
        setTwo();
    }
    else if (e.code == "ArrowUp") {
        slideUp();
        setTwo();

    }
    else if (e.code == "ArrowDown") {
        slideDown();
        setTwo();
    }
    document.getElementById("score").innerText = score;
})

function filterZero(row){
    return row.filter(num => num != 0); //create new array of all nums != 0
}

function slide(row) {
    //[0, 2, 2, 2] 
    row = filterZero(row); //[2, 2, 2]
    for (let i = 0; i < row.length-1; i++){
        if (row[i] == row[i+1]) {
            row[i] *= 2;
            row[i+1] = 0;
            score += row[i];
        }
    } //[4, 0, 2]
    row = filterZero(row); //[4, 2]
    //add zeroes
    while (row.length < columns) {
        row.push(0);
    } //[4, 2, 0, 0]
    return row;
}

function slideLeft() {
    for (let r = 0; r < rows; r++) {
        let row = board[r];
        row = slide(row);
        board[r] = row;
        for (let c = 0; c < columns; c++){
            let tile = document.getElementById(r.toString() + "-" + c.toString());
            let num = board[r][c];
            updateTile(tile, num);
        }
    }
}

function slideRight() {
    for (let r = 0; r < rows; r++) {
        let row = board[r];         //[0, 2, 2, 2]
        row.reverse();              //[2, 2, 2, 0]
        row = slide(row)            //[4, 2, 0, 0]
        board[r] = row.reverse();   //[0, 0, 2, 4];
        for (let c = 0; c < columns; c++){
            let tile = document.getElementById(r.toString() + "-" + c.toString());
            let num = board[r][c];
            updateTile(tile, num);
        }
    }
}

function slideUp() {
    for (let c = 0; c < columns; c++) {
        let row = [board[0][c], board[1][c], board[2][c], board[3][c]];
        row = slide(row);
        // board[0][c] = row[0];
        // board[1][c] = row[1];
        // board[2][c] = row[2];
        // board[3][c] = row[3];
        for (let r = 0; r < rows; r++){
            board[r][c] = row[r];
            let tile = document.getElementById(r.toString() + "-" + c.toString());
            let num = board[r][c];
            updateTile(tile, num);
        }
    }
}

function slideDown() {
    for (let c = 0; c < columns; c++) {
        let row = [board[0][c], board[1][c], board[2][c], board[3][c]];
        row.reverse();
        row = slide(row);
        row.reverse();
        // board[0][c] = row[0];
        // board[1][c] = row[1];
        // board[2][c] = row[2];
        // board[3][c] = row[3];
        for (let r = 0; r < rows; r++){
            board[r][c] = row[r];
            let tile = document.getElementById(r.toString() + "-" + c.toString());
            let num = board[r][c];
            updateTile(tile, num);
        }
    }
}

function setTwo() {
    if (!hasEmptyTile()) {
        return;
    }
    let found = false;
    while (!found) {
        //find random row and column to place a 2 in
        let r = Math.floor(Math.random() * rows);
        let c = Math.floor(Math.random() * columns);
        if (board[r][c] == 0) {
            board[r][c] = 2;
            let tile = document.getElementById(r.toString() + "-" + c.toString());
            tile.innerText = "2";
            tile.classList.add("x2");
            found = true;
        }
    }
}

function hasEmptyTile() {
    let count = 0;
    for (let r = 0; r < rows; r++) {
        for (let c = 0; c < columns; c++) {
            if (board[r][c] == 0) { //at least one zero in the board
                return true;
            }
        }
    }
    return false;
}

function isGameOver() {
    // Check if there are any empty tiles
    if (!hasEmptyTile()) {
        // Check if there are any valid moves left
        for (let r = 0; r < rows; r++) {
            for (let c = 0; c < columns; c++) {
                // Check if adjacent tiles have the same value
                if ((c < columns - 1 && board[r][c] === board[r][c + 1]) ||
                    (r < rows - 1 && board[r][c] === board[r + 1][c])) {
                    return false; // Valid move found
                }
            }
        }
        return true; // No valid moves left
    }
    return false; // There are empty tiles, the game is not over yet
}
let gameOverPromptShown = false;

function showGameOverScreen() {
    if (!gameOverPromptShown) {
        gameOverPromptShown = true;

        const playerName = prompt('Game Over! Enter your name:');
        if (playerName !== null) {
            // If the player entered a name (not canceled)
            const playerScore = score;
            submitScore(playerName, playerScore);

            // Reload the page after a delay (1000 milliseconds = 1 second)
            setTimeout(() => {
                location.reload();
            }, 15000);
        }
    }
}


function displayTopScores() {
    // Use AJAX to fetch top scores from the database
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Parse the response and display the top scores
                let scores = JSON.parse(xhr.responseText);
                showTopScoresTable(scores);
            } else {
                console.error("Error fetching top scores");
            }
        }
    };
    xhr.open("POST", "submitS4.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("auslesen=true");
}

function showTopScoresTable(scores) {
    // Create a table to display top scores
    let table = "<table><tr><th>Username</th><th>Score</th><th>Date</th></tr>";
    for (let i = 0; i < scores.length; i++) {
        table += "<tr><td>" + scores[i].USERNAME + "</td><td>" + scores[i].SCORE + "</td><td>" + scores[i].DATE + "</td></tr>";
    }
    table += "</table>";

    // Display the table
    document.body.innerHTML += table;
}
function submitScore(username, score) {
    // Make an AJAX request to submit the score using submitS5.php or any other backend logic
    // You can use XMLHttpRequest, Fetch API, or any other method to send data to the server
    // For simplicity, I'll assume you have a submitS5.php script for submitting scores
    // Modify this function based on your backend implementation

    // Example using Fetch API:
    fetch('submitS4.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `username=${encodeURIComponent(username)}&score=${encodeURIComponent(score)}`,
    })
    .then(response => response.text())
    .then(data => console.log(data))
    .catch(error => console.error('Error submitting score:', error));
}
