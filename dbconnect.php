<?php
$servername = "localhost";
$user = "root";
$password = "root";
$dbname = "secureu";

// Create connection
$conn = mysqli_connect($servername, $user, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
