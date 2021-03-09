<?php
$hostname = "localhost:3316";
$username = "root";
$password = "";
$dbname = "movdb";
$conn = mysqli_connect($hostname, $username, $password,$dbname);

/*
$hostname = "217.208.61.188";
$username = "imssnowu";
$password = "LioMi6009";
$dbname = "imssnowwhite";
$conn = mysqli_connect($hostname, $username, $password,$dbname);
*/

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }

?>
