<?php
function dateTimeToElement($startTime,$endTime) {
    $startTime = strtotime($startTime);
    $endTime = strtotime($endTime);
    $start = date_create();
    $end = date_create();
    date_timestamp_set($start,$startTime);
    date_timestamp_set($end,$endTime);
    
    $diff = $start->diff($end);
    $hour_diff = $diff -> format('%h');
    $min_diff = $diff -> format('%i');
    $time_diff = $hour_diff + ($min_diff/60);
    return ($time_diff);
}

#get protocols
function get_protocols() {
  include('db.php');
  $sql = "SELECT protocols.ProtName
  FROM protocols"; 


  $stmt = mysqli_stmt_init($conn);
  if($stmt =$conn->prepare($sql)) {

    mysqli_stmt_execute($stmt);
    $stmt->bind_result($protName);
    
  }
  
  
  while($stmt->fetch()) {
      $protNames[] = $protName;
  }
  $stmt->close();
include('closeDB.php');
return $protNames;
}

// Get userID of logged in user
function get_current_user_id() {
  if (!isset($_SESSION['userID'])){
    return 0;
  } 
  return $_SESSION['userID'];
}