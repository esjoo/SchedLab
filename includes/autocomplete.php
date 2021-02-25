<?php 

include('../db.php');
    /*$sql = "SELECT UserName
    FROM Users"; 

    $stmt = mysqli_stmt_init($conn);
    if($stmt =mysqli_prepare($conn, $sql)) {

        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$dbNames);
        $number_of_records = $stmt->num_rows;
        mysqli_stmt_store_result ($stmt);
    }*/

    $sql = "SELECT UserName
    FROM Users"; 

    $stmt = mysqli_stmt_init($conn);
    if($stmt =mysqli_prepare($conn, $sql)) {

        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$result);
        mysqli_stmt_store_result($stmt);
    }
    
    
    while(mysqli_stmt_fetch($stmt)) {
        $dbNames[] = $result;
    }

    

    


include('../closeDB.php');

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
echo $hint === "" ? "" : $hint;