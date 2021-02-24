<?php
$hostname = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "movdb";
$conn = mysqli_connect($hostname, $username, $password,$dbname);

if (!$conn){
  echo "Error: Unable to connect to MySQL." .
  mysqli_connect_error() . PHP_EOL;
exit;
}
?>
