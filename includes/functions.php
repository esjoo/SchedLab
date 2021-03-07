<?php

if(!isset($_SESSION)) {
  session_start();
}

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


//get protocolID from input name
function get_protocolID($protocolName) {
  include('db.php');
    $sql =  'SELECT protID FROM  protocols WHERE ProtName =?';
    $stmt = mysqli_stmt_init($conn);

    if($stmt =$conn->prepare($sql)) {

        $stmt->bind_param("s",$protocolName);
        mysqli_stmt_execute($stmt);
        $stmt->bind_result($protID);
        $protID = $stmt->fetch();
        $stmt->close();
    }
  include('closeDB.php');
  return $protID;
  }



// Get userID of logged in user
function get_current_user_id() {
  if (!isset($_SESSION['userID'])){
    return 0;
  } 
  return $_SESSION['userID'];
}

// Get lab of logged in user
function get_current_user_lab() {
  if (!isset($_SESSION['lab'])){
    return 0;
  } 
  return $_SESSION['lab'];
}

// Get labname of logged in user
function get_current_user_labName() {
  if (!isset($_SESSION['lab'])){
    return 0;
  } 
  $labID = $_SESSION['lab'];
  include "db.php";
  $sql = "SELECT LabName FROM lab WHERE LabID=$labID";
  $result = mysqli_query($conn, $sql);
  include "closeDB.php";
  if($r = mysqli_fetch_row($result)) {
    return $r[0];
  }
}



//Get supplement list WHERE ProtID
function getInventory($protID) {
  include('db.php');

  $sql =  'SELECT inventory.Amount as stock, inventory.SupID, protocolguide.Dosage as dose  
  FROM inventory
  INNER JOIN protocolguide ON inventory.UserID= ? AND inventory.SupID=protocolguide.SupID AND protocolguide.ProtID = ?';
  $stmt = mysqli_stmt_init($conn);

  
  if($stmt =$conn->prepare($sql)) {
    
      $stmt->bind_param("ss",$_SESSION['userID'],$protID);
    
      $stmt->execute();

      $stmt->bind_result($stock,$supID, $dose);
     
      while ($stmt->fetch()) {
        
        $stocks[] = $stock;
        $supIDs[] = $supID;
        $doses[] = $dose;
        
    }
      

      $stmt->close();
    include('closeDB.php');
    return array($stocks,$supIDs, $doses);  
  }
  
}



//checkInventory 
//Param ->Inventory as array supplements as array :bool
function checkInventory($inventory,$supplements) {
  $func = function($a,$b) {
    return $a-$b;
};

return min(array_map($func, $inventory,$supplements))>=0;
} 

