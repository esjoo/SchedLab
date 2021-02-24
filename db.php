<?php
$hostname = "localhost:3316";
$username = "root";
$password = "";
$dbname = "protest";
$conn = mysqli_connect($hostname, $username, $password,$dbname);

if (!$conn) {
  echo "Error: Unable to connect to MySQL." .
  mysqli_connect_error() . PHP_EOL;
exit;
}
?>
