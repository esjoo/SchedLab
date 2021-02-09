<?php 

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
