<?php
$hostname = "localhost:3316";
$username = "root";
$password = "";
$dbname = "protest";
$conn = mysqli_connect($hostname, $username, $password,$dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }

?>
