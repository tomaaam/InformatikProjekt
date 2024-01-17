<?php
// connector.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "informatikhighscores";

// Create connection
$db_link = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$db_link) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Function to run SQL queries
function runSQL($query) {
    global $db_link;
    return mysqli_query($db_link, $query);
}
    
?>