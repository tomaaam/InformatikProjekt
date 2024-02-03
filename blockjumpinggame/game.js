// Get the canvas context
const context = document.querySelector("canvas").getContext("2d");

// Set canvas dimensions
context.canvas.height = window.innerHeight-(window.innerHeight/8);
context.canvas.width = window.innerWidth-(window.innerWidth/12);

// Initialize frame count and obstacles count
let frameCount = 1;
let obCount = frameCount;

//velocety the blocks move to the left(for not stopping them instantly tather using friction to come to a "soft" stop)
let blockvel=0;

// Arrays to hold obstacle coordinates and heights
let obXCoors = [];
let obHeights = [];

// Flag for game end
let gameEnded = false;

const playerImages = {
  runningRight: [new Image(), new Image()],
  runningLeft: [new Image(), new Image()],
  standing: new Image(),
  jumpingRight: new Image(),
  jumpingLeft: new Image()
};
const backgroundImage = new Image();
const groundImage = new Image();

// Load images
playerImages.runningRight[0].src = 'Run_Right_1.png';
playerImages.runningRight[1].src = 'Run_Right_2.png';
playerImages.runningLeft[0].src = 'Run_Left_1.png';
playerImages.runningLeft[1].src = 'Run_Left_2.png';
playerImages.standing.src = 'IDLE.png';
playerImages.jumpingRight.src = 'Jump_Right.png';
playerImages.jumpingLeft.src = 'Jump_Left.png';
backgroundImage.src = 'player-4.jpg';
groundImage.src = 'player-3.jpg';

// Player object
const square = {
  height: 64,
  jumping: true,
  width: 32,
  x: 0,
  xVelocity: 0,
  y: 0,
  yVelocity: 0
};

// Score tracking
let score = 0;
// Create a container for the score display
const scoreContainer = document.createElement('div');
scoreContainer.setAttribute('id', 'score-container');
scoreContainer.style.position = 'absolute';
scoreContainer.style.top = '10px'; // Adjust the top position as needed
scoreContainer.style.left = '50%';
scoreContainer.style.transform = 'translateX(-50%)';
scoreContainer.style.width = `${context.canvas.width}px`; // Set the width of the score container to match the canvas
scoreContainer.style.display = 'block';
scoreContainer.style.textAlign = 'center';
scoreContainer.style.color = '#FFF'; // Adjust the color as needed
scoreContainer.style.fontSize = '20px'; // Adjust the font size as needed
scoreContainer.innerText = `Score: ${score}`;

document.body.appendChild(scoreContainer);

// Update score function
function updateScore() {
  score++;
  scoreContainer.innerText = `Score: ${score}`;
}

// Show end screen function
async function showEndScreen() {
  if (!gameEnded) {
    gameEnded = true;
    document.body.innerHTML = '';

    const endScreen = document.createElement('div');
    endScreen.setAttribute('id', 'end-screen');

    // Fetch top 5 scores from the server
    let topScores;
    try {
      const response = await getTopScores();
      topScores = response.topScores;
      console.log('Top Scores:', topScores);  // Log top scores for debugging
    } catch (error) {
      console.error('Error fetching top scores:', error);
    }

    // Check if topScores is defined and has a length property
    if (topScores && topScores.length) {
      // Create a table element
      const scoreTable = document.createElement('table');

      // Add table headers
      const headerRow = document.createElement('tr');
      const rankHeader = document.createElement('th');
      const nameHeader = document.createElement('th');
      const scoreHeader = document.createElement('th');
      rankHeader.innerText = 'Rank';
      nameHeader.innerText = 'Name';
      scoreHeader.innerText = 'Score';
      headerRow.appendChild(rankHeader);
      headerRow.appendChild(nameHeader);
      headerRow.appendChild(scoreHeader);
      scoreTable.appendChild(headerRow);

      // Populate the table with top scores
      topScores.forEach((score, index) => {
        const row = document.createElement('tr');
        const rankCell = document.createElement('td');
        const nameCell = document.createElement('td');
        const scoreCell = document.createElement('td');
        rankCell.innerText = (index + 1).toString();
        nameCell.innerText = score.username;
        scoreCell.innerText = score.score.toString();
        row.appendChild(rankCell);
        row.appendChild(nameCell);
        row.appendChild(scoreCell);
        scoreTable.appendChild(row);
      });

      // Apply CSS styling for centering and moving up
      scoreTable.style.marginTop = '10px';
      scoreTable.style.marginBottom = '20px';
      scoreTable.style.marginLeft = 'auto';
      scoreTable.style.marginRight = 'auto';

      // Add the table to the end screen
      endScreen.appendChild(scoreTable);

      // Example: Log usernames and scores
      topScores.forEach(score => {
        console.log(`Username: ${score.username}, Score: ${score.score}`);
      });
    } else {
      console.error('Top scores are undefined or have no length property');
    }
   
    const scoreText = document.createElement('p');
    scoreText.innerText = `Your score: ${score}`;
    
    const nameLabel = document.createElement('label');
    nameLabel.innerText = 'Enter your name: ';
    const nameInput = document.createElement('input');
    nameInput.setAttribute('type', 'text');
    
    const submitButton = document.createElement('button');
    submitButton.innerText = 'Submit';
    submitButton.disabled = false;
    submitButton.addEventListener('click', () => {
        const playerName = nameInput.value.trim(); // Trim any leading or trailing spaces
        if (playerName !== '') { // Check if the input is not empty
            simulateDataTransfer(playerName, score);
            console.log(`Player: ${playerName}, Score: ${score}`);
            submitButton.disabled = true;
            setTimeout(() => {
                window.location.reload();
            }, 40000);
        } else {
          const playerName = "Anonym"
            simulateDataTransfer(playerName, score);
            console.log(`Player: ${playerName}, Score: ${score}`);
            submitButton.disabled = true;
            setTimeout(() => {
                window.location.reload();
            }, 20000);
        }
    });

    endScreen.appendChild(scoreText);
    endScreen.appendChild(nameLabel);
    endScreen.appendChild(nameInput);
    endScreen.appendChild(submitButton);
    
    document.body.appendChild(endScreen);
    nameInput.focus();
    
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Enter') {
        event.preventDefault();
        submitButton.click();
      }
    });
  }
}


// Game over handler
function handleGameOver() {
  if (!gameEnded) {
    showEndScreen();
  }
}

// Function to fetch top 5 scores from the server
async function getTopScores() {
  return new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'getTopScores.php', true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
          try {
            const topScores = JSON.parse(xhr.responseText);
            resolve(topScores);
          } catch (error) {
            console.error('Error parsing JSON:', error);
            reject('Invalid JSON');
          }
        } else {
          console.error('HTTP request failed with status:', xhr.status);
          reject('HTTP Error');
        }
      }
    };
    xhr.send();
  });
}

// Simulate data transfer function
async function simulateDataTransfer(username, score) {
  // Create a new XMLHttpRequest object
  var xhr = new XMLHttpRequest();

  // Specify the type of request (POST) and the URL to send the request to
  xhr.open('POST', 'submitS1.php', true);

  // Set the content type of the request
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  // Define the function to handle the response from the server
  xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200) {
          // Handle the response from the server (if needed)
          console.log(xhr.responseText);
      }
  };

  // Prepare the data to be sent to the server
  var data = 'submit=true&username=' + encodeURIComponent(username) + '&score=' + encodeURIComponent(score);

  // Send the request with the data
  xhr.send(data);
}


// Initialize the first frame
const nextFrame = () => {
  if (frameCount === 1) {
    const initialRowCount = Math.floor(context.canvas.width/100)+1;
    //console.log(initialRowCount)
    const squareSize = 100;
    const startX = (context.canvas.width - initialRowCount * squareSize) / 2;

    for (let i = 0; i < initialRowCount; i++) {
      obXCoor = startX + i * squareSize;
      obXCoors.push(obXCoor);
      obHeights.push(context.canvas.height - squareSize);
    }

    // Set the initial position of the player square
    square.x = 50; // Adjust this value based on your desired starting point
    square.y = context.canvas.height - square.height*4; // Adjust this value for the height of the square from the bottom
  } 
  frameCount++;
};

// Keyboard controller
const controller = {
  left: false,
  right: false,
  up: false,
  keyListener: function (event) {
    var key_state = (event.type === "keydown");

    switch (event.keyCode) {
      case 37: // left key or 'A'
      case 65: // 'A'
        controller.left = key_state;
        break;
      case 32: // 'Space'
      case 38: // up key or 'W'
      case 87: // 'W'
        controller.up = key_state;
        break;
      case 39: // right key or 'D'
      case 68: // 'D'
        controller.right = key_state;
        break;
      case 40: // down key or 'S' (optional)
      case 83: // 'S' (optional)
        // Additional handling for down key or 'S' if needed
        break;
    }
  }
};

// Check collision function
function checkCollision(square, obXCoor, obYCoor, size) {
  var dx = (square.x + square.width / 2) - (obXCoor + size / 2);
  var dy = (square.y + square.height / 2) - (obYCoor + size / 2);
  var width = (square.width + size) / 2;
  var height = (square.height + size) / 2;
  var crossWidth = width * dy;
  var crossHeight = height * dx;
  var collision = 'none';

  if (Math.abs(dx) <= width && Math.abs(dy) <= height) {
    if (crossWidth > crossHeight) {
      collision = (crossWidth > -crossHeight) ? 'bottom' : 'left';
    } else {
      collision = (crossWidth > -crossHeight) ? 'right' : 'top';
    }
  }
  return collision;
}

// Update next frame and loop functions
nextFrame();
const loop = function () {
  let onTopOfSquare = false;
  if (controller.up && square.jumping == false) {
      square.yVelocity -= 40;
      square.jumping = true;
    }
  
    if (controller.left) {
      square.xVelocity -= 3;
    }
  
    if (controller.right) {
      if (square.x < context.canvas.width/5) {
        square.xVelocity += 3;
      } else {
        square.xVelocity += 0; // Reduce the speed after 500 pixels
        blockvel+=3; // Move the squares to the left
        updateScore(); // Call this function to update the score when the player moves or obstacles shift
      }
    }
    if (!controller.right && square.xVelocity > 0) {
      square.xVelocity *=0.9999; // Apply friction when the right key is released
      if (square.xVelocity < 0) {
        square.xVelocity = 0; // Ensure the velocity doesn't become negative
      }
    }
    square.x += square.xVelocity;
    square.y += square.yVelocity;
    obXCoors = obXCoors.map(x => x - blockvel); // Move the squares to the left
    blockvel*=0.7
    square.xVelocity *= 0.7;
    square.yVelocity *= 0.9;
    
    // if square is falling below floor line
    //square.jumping=true;
    if (square.y > context.canvas.height - 30 - square.height) {
      handleGameOver();} // Call function to display the end screen
    // if square is going off the left of the screen
    if (square.x < 0) {
      square.x = 0;
      square.xVelocity=0
    } else if (square.x > context.canvas.width-square.width) {// if square goes past right boundary
      square.x = context.canvas.width-square.width;
      square.xVelocity=0
    }
  
    // Creates the backdrop for each frame
    context.fillStyle = "#201A23";
    context.fillRect(0, 0, context.canvas.width, context.canvas.height); // x, y, width, height

    
    if (!square.jumping && (Math.floor(square.xVelocity) !== 0 || Math.floor(blockvel) !== 0)) {
      const animationFrame = Math.floor(frameCount / 10) % 2; // Adjust the divisor for animation speed
      let playerImage;
      if (square.xVelocity > 0) {
        playerImage = playerImages.runningRight[animationFrame];
      } else {
        playerImage = playerImages.runningLeft[animationFrame];
      }
    
      context.drawImage(playerImage, square.x, square.y, square.width, square.height);
    } else if (square.jumping && (square.xVelocity > 0 || blockvel < 0)) {
      context.drawImage(playerImages.jumpingRight, square.x, square.y, square.width, square.height);
    } else if (square.jumping && (square.xVelocity < 0 || blockvel > 0)) {
      context.drawImage(playerImages.jumpingLeft, square.x, square.y, square.width, square.height);
    }else {
      context.drawImage(playerImages.standing, square.x, square.y, square.width, square.height);
    }
    
    frameCount++
    // Create the obstacles for each frame
    context.fillStyle = "#FBF5F3"; // hex for square color

    obXCoors.forEach((obXCoor, index) => {
      let fixedHeight = obHeights[index];

      // Draw a square
      context.fillRect(obXCoor, fixedHeight, 102, 100);
    
      var collision = checkCollision(square, obXCoor, fixedHeight, 100);
      if (collision !== 'none') {
        //console.log('Collision detected!');
        if (collision === 'bottom') {
          square.y = fixedHeight + 2*square.height;
          square.yVelocity = 0;
        } else if (collision === 'left') {
          square.x = obXCoor - square.width;
          square.xVelocity = 0;
        } else if (collision === 'right') {
          square.x = obXCoor + 100;
          square.xVelocity = 0;
        } else if (collision === 'top') {
          square.y = fixedHeight - square.height; // Set the player on top of the square
          square.yVelocity = 2; // Apply a small velocity to simulate falling after hitting the top
          square.jumping = false; // Disable jumping temporarily
        }
      }
    
      // Prevent jumping through squares from the bottom
      if (collision === 'bottom' && square.y < fixedHeight && square.y + square.height > fixedHeight) {
        square.y = fixedHeight - square.height - 1;
        square.yVelocity = 0;
      }
    });
  if (!onTopOfSquare) {
    square.yVelocity += 2; }// gravity
  // Remove squares that are off the screen and add new ones
  obXCoors = obXCoors.filter((x, i) => {
    if (x < -100) {
      obHeights.splice(i, 1);
      return false;
    }
    return true;
  });
  let distanceOptions = [50,50,200,200,100,150,150,100,100,100];
if (frameCount % 2 === 0) {
  if (obXCoors[obXCoors.length - 1]+distanceOptions[Math.floor(Math.random() *10)] <= context.canvas.width - 100) {
    let obXCoor = context.canvas.width;
    // Spawn the new square at a height that is 50 pixels higher, the same, or 50 pixels lower than the previous square
    let minHeight = context.canvas.height * 0.6; // Minimum height constraint, set to 60% of canvas height for initial terrain height (near the bottom)
    let maxHeight = context.canvas.height * 0.9; // Maximum height constraint, set to 90% of canvas height for maximum terrain height (near the top)

    let changeOptions = [-100, -50, 0, 50, 100, 150, 300]; // Possible changes to create varied terrain, including a large positive value for spikes

    let change = 0;
    let lastHeight = obHeights[obHeights.length - 1];

    // Generate terrain with a higher chance of going up
    do {
        change = changeOptions[Math.floor(Math.random() * changeOptions.length)];
    } while (
        (lastHeight === minHeight && change < 0) || // Avoid generating terrain below the minimum height
        (lastHeight === maxHeight && change > 0) || // Avoid generating terrain above the maximum height
        (lastHeight + change < minHeight) || // Ensure generated terrain doesn't dip below the minimum height
        (lastHeight + change > maxHeight) // Ensure generated terrain doesn't rise above the maximum height
    );

    let obYCoor = lastHeight + change;

    // Adjust the width of the obstacles based on the change value
    let obWidth = 102 + Math.abs(change);
    if (obWidth > 150) {
        obWidth = 150; // Set a maximum width for the obstacles
    }

    obHeights.push(obYCoor);

    if (change === 300) {
        obXCoors.push(-300); // Add a placeholder value for the spike, indicating no obstacle to be drawn
    } else {
        obXCoors.push(obXCoor); // Add the X coordinate for regular terrain
    }
    obHeights.push(obYCoor);
  }}

// Creates the "ground" for each frame
context.strokeStyle = "#2E2532";
context.lineWidth = 30;
context.beginPath();
context.moveTo(0, context.canvas.height-15);
context.lineTo(context.canvas.width, context.canvas.height-15);
context.stroke();

  // call update when the browser is ready to draw again
  window.requestAnimationFrame(loop);
};

// Start the animation and event listeners
window.addEventListener("keydown", controller.keyListener)
window.addEventListener("keyup", controller.keyListener);
window.requestAnimationFrame(loop);
