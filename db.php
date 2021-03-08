<?php
$hostname = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "movdb";
$conn = mysqli_connect($hostname, $username, $password,$dbname);


$host = 'sql7.freemysqlhosting.net';
$user = 'sql7391808';
$pswd = 'rbq4yR7P4v';
$database = 'sql7391808';
$conn = mysqli_connect($host,$user,$pswd,$database); 

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }

?>
