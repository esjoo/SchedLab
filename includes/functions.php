<?php
function dateTimeToElement($startTime,$endTime) {
    $start = date_create();
    $end = date_create();
    date_timestamp_set($start,$startTime);
    date_timestamp_set($end,$endTime);
    
    $diff = $start->diff($end);
    return ( $diff->format('%h'));
}

#get protocols
function get_protocols() {
    include('db.php');
    $sql = "SELECT UserName
    FROM Users"; 

    $stmt = mysqli_stmt_init($conn);
    if($stmt =mysqli_prepare($conn, $sql)) {

        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$dbNames);
        mysqli_stmt_store_result ($stmt);
    }
    include('closeDB.php');

    // get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
  $q = strtolower($q);
  $len=strlen($q);
  foreach($dbNames as $name) {
    if (stristr($q, substr($name, 0, $len))) {
      if ($hint === "") {
        $hint = $name;
      } else {
        $hint .= ", $name";
      }
    }
  }
}

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "no suggestion" : $hint;
}