<?php

/**
 * Filename: connection.php
 * Description: Diary Web App
 * Author: Amish Trivedi
 * Date developed: 12-Nov-2019
 * Version: 1.0
 */

$servername = "localhost";
$username = "root";
$password = "root";
$db = "diary"; 

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";

?>