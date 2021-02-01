<?php 

$host = 'localhost';
$user = 'root';
$pswd = '';
$database = 'movdb';
$conn = mysqli_connect($host,$user,$pswd,$database); 

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }
?>
