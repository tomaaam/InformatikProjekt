<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
    }
    #word-container {
      margin-top: 20px;
      font-size: 24px;
    }
    #guess-input {
      margin-top: 10px;
      padding: 5px;
    }
    #feedback {
      margin-top: 10px;
      color: #FF0000;
      font-weight: bold;
    }
    #used-letters {
      margin-top: 10px;
      font-size: 18px;
    }
    #hangman-image {
      max-width: 500px; /* Begrenzung der Bildbreite auf 500 Pixel */
    }
  </style>
  <title>Hangman Spiel</title>
</head>
<body>

<audio id="lose-sound">
  <source src="sound.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>

<div>
  <h1>Hangman Spiel</h1>
  <!-- Bild Hangman -->
  <img id="hangman-image" src="hangman0.png" alt="Hangman Bild">
  <!-- wortcontainer -->
  <div id="word-container"></div>
  <!-- Eingabefeld für Buchstaben -->
  <input type="text" id="guess-input" placeholder="Buchstabe eingeben">
  <!-- Button zum Raten -->
  <button onclick="guessLetter()">Raten</button>
  <!-- Neustart-Button -->
  <button onclick="restartGame()">Neustart</button>
  <!-- Rückmeldung für den Spieler -->
  <p id="feedback"></p>
  <!-- Anzahl der falschen Versuche -->
  <p>Fehler: <span id="attempts">0</span></p>
  <!-- Anzeige bereits verwendeter Buchstaben -->
  <div id="used-letters"></div>
</div>

<script>
  // Liste von Wörtern für das Spiel
  let wordList = ["rostesel", "xylophon", "parabel", "exorbitant", "atomkraftwerk", "klimakleber"];
  // Zufällige Auswahl eines Wortes aus der Liste
  let chosenWord = wordList[Math.floor(Math.random() * wordList.length)];
  // Array für geratene Buchstaben
  let guessedLetters = [];
  // Verbleibende Versuche
  let remainingAttempts = 6;

  // Funktion zur Anzeige des zu erratenden Worts
  function displayWord() {
    let display = "";
    for (let char of chosenWord) {
      if (guessedLetters.includes(char)) {
        display += char + " ";
      } else {
        display += "_ ";
      }
    }
    document.getElementById("word-container").innerText = display.trim();
    return display.trim(); // Rückgabe des Anzeigetexts für Überprüfung auf Gewinn
  }

  // Funktion zur Aktualisierung des Hangman-Bildes
  function updateHangmanImage() {
    let hangmanImage = document.getElementById("hangman-image");
    let imageNumber = 6 - remainingAttempts;
    hangmanImage.src = "hangman" + imageNumber + ".png";
  }

  // Funktion für den Buchstabenvorschlag
  function guessLetter() {
    let inputElement = document.getElementById("guess-input");
    let feedbackElement = document.getElementById("feedback");
    let attemptsElement = document.getElementById("attempts");
    let usedLettersElement = document.getElementById("used-letters");
    let guessedLetter = inputElement.value.toLowerCase();

    // Überprüfen, ob das Spiel bereits vorbei ist
    if (remainingAttempts === 0 || !displayWord().includes("_")) {
      feedbackElement.innerText = "Das Spiel ist vorbei!👍";
      return;
    }

    // Überprüfen, ob der Buchstabe bereits geraten wurde
    if (guessedLetters.includes(guessedLetter)) {
      feedbackElement.innerText = "Du hast diesen Buchstaben bereits geraten😡!!!";
      return;
    }
    // Überprüfen, ob die Eingabe ein einzelner Buchstabe ist
    if (!/^[a-zA-Z]$/.test(guessedLetter)) {
      feedbackElement.innerText = "Bitte gib einen einzelnen Buchstaben ein";
      return;
  }
    // Hinzufügen des Buchstabens zu den geratenen Buchstaben
    guessedLetters.push(guessedLetter);

    // Überprüfen, ob der Buchstabe im Wort enthalten ist
    if (!chosenWord.includes(guessedLetter)) {
      remainingAttempts--;
      feedbackElement.innerText = "Falscher Buchstabe 😤. Verbleibende Versuche: " + remainingAttempts;
      // Aktualisierung des Hangman-Bildes
      updateHangmanImage();
    }

    // Aktualisierung der Anzahl der Fehler
    attemptsElement.innerText = 6 - remainingAttempts;

    // Anzeige der verwendeten Buchstaben
    usedLettersElement.innerText = "Verwendete Buchstaben: " + guessedLetters.join(", ");

    // Überprüfen auf Spielende
    if (remainingAttempts === 0) {
      feedbackElement.innerText = "Das Spiel ist vorbei. Das Wort war: " + chosenWord;
      // Sound abspielen, wenn der Spieler verliert
      document.getElementById("lose-sound").play();
    } else {
      // Anzeige des zu erratenden Worts
      let wordDisplay = displayWord();

      // Überprüfen auf Gewinn
      if (!wordDisplay.includes("_")) {
        feedbackElement.innerText = "Herzlichen Glückwunsch! Du hast gewonnen!";
      }

      // Zurücksetzen der Eingabe und Rückmeldung
      inputElement.value = "";
      feedbackElement.innerText = "";
    }
  }

  // Funktion für den Neustart des Spiels
  function restartGame() {
    // Zufällige Auswahl eines neuen Wortes
    chosenWord = wordList[Math.floor(Math.random() * wordList.length)];
    // Zurücksetzen der geratenen Buchstaben und Versuche
    guessedLetters = [];
    remainingAttempts = 6;
    // Zurücksetzen der Anzeige
    displayWord();
    updateHangmanImage();
    document.getElementById("guess-input").value = "";
    document.getElementById("feedback").innerText = "";
    document.getElementById("attempts").innerText = "0";
    document.getElementById("used-letters").innerText = "";
  }

  // Funktion Tastatureingabe
  document.getElementById("guess-input").addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
      guessLetter(); // Rufe die Funktion guessLetter auf, wenn Enter gedrückt wird


    }
  });

  // Initialer Aufruf zur Anzeige des zu erratenden Worts
  displayWord();
  // Initialer Aufruf zur Anzeige des Hangman-Bildes
  updateHangmanImage();
</script>

</body>
</html>
