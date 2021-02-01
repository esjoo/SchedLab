<?php 
include_once('header.php');
include_once('db.php');

$sql = "SELECT * FROM movies";
$result = mysqli_query($con, $sql);

// Associative array
$row = mysqli_fetch_assoc($result);

print_r($result);

// Free result set
mysqli_free_result($result);

mysqli_close($con);

include_once('footer.php');


?>