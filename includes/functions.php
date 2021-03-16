<?php

if(!isset($_SESSION)) {
  session_start();
}
// CALENDAR
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

function getCalendarWeek($week) {
  include('db.php');
  $sql =  "SELECT usercalendar.calenID, usercalendar.FromDateTime,usercalendar.TillDateTime, protocols.ProtName,protocols.ProtMethod  
  FROM usercalendar
  INNER JOIN protocols ON usercalendar.ProtID = protocols.ProtID
  WHERE WEEK(usercalendar.FromDateTime,1)=$week AND usercalendar.UserID = ".$_SESSION['userID']." ORDER BY FromDateTime";
  
  
  if ($result = $conn->query($sql)) {  
    //GET DAY
    return $result->fetch_all(MYSQLI_ASSOC);
  } else {
    return 0;
}
}
//Creates array with events in specified day
//Param: $w week from getCalendarWeek, $day specified day string (Monday .. Sunday) 
function filterWeek($week,$day){

  $result= array_filter($week, function ($var) use ($day) {
        return (date('l', strtotime($var['FromDateTime'])) == $day);
});
return array_values($result);
}

//Prints weekday 
//Param: $w week from getCalendarWeek, $numDay day specified 1->Monday..7->Sunday 
function printWeekday($w,$numDay) {
 
  if(count($w)==0) { //Return if there is nothing planned
    return "";
    }

  $weekdays = ['','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

  //get events in day from week
  $eventDay = filterWeek($w,$weekdays[$numDay]);
 
  //Print events IN day
  //initialise previous time
  $prevEndTime = '08:00:00';
 
  foreach($eventDay as $event) {
    
    $startTime = (explode(" ",$eventDay[0]['FromDateTime']))[1]; //keep timepart
    $EndTime = (explode(" ",$eventDay[0]['TillDateTime']))[1];


    if ($event==array_key_first($eventDay)){ 
      $eventMargin = dateTimeToElement('08:00:00',$startTime)/11*100 .'%'; //First event of the day
    } else {
      $eventMargin = dateTimeToElement($prevEndTime,$startTime)/11*100 .'%';
    }
    $eventTime = dateTimeToElement($startTime,$EndTime)/11*100 .'%';
    printf('
          <div class="col mr-1 border p-0 day btn-calendar" data-toggle="modal" data-target="#exampleModal" data-calenID="%s" data-startTime="%s" data-endTime="%s" data-protocolHead="%s" data-protocolContent="%s" style="height:%s;margin-top:%s;">%s</div>
              ',$event['calenID'], //calendar id
              $startTime,  
              $EndTime,
              $event['ProtName'], //Protocol name
              $event['ProtMethod'], //protocol method
              $eventTime, //top margin for spacing
              $eventMargin, //The time allocated for event
              $event['ProtName']); //Protocolname displayed on button

    $prevEndTime = $EndTime; //set endtime to calculate spacing
  } 
 
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
  $protName = $conn ->real_escape_string($protocolName);
    $sql =  "SELECT protID FROM protocols WHERE protName=".'"'.$protocolName.'"';
    if ($result = $conn->query($sql)) {  
      return $result->fetch_array(MYSQLI_NUM)[0];
  } else {
    print $sql;
    return -1;
  }
  include('closeDB.php');
  }

//get protocol name from id

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



//Get supplement list WHERE ProtID: Returns array of arrays (Inventory stocks,supplementIDs,protocol required dosages)
function getInventory($protID) {
  include('db.php');
  print($protID);
  $sql =  'SELECT inventory.Amount as stock, inventory.SupID, protocolguide.Dosage as dose  
  FROM inventory
  INNER JOIN protocolguide ON inventory.LabID= ? AND inventory.SupID=protocolguide.SupID AND protocolguide.ProtID = ?';
  $stmt = mysqli_stmt_init($conn);
  

  if($stmt =$conn->prepare($sql)) {
    
      $stmt->bind_param("ss",$_SESSION['lab'],$protID);
    
      $stmt->execute();

      $stmt->bind_result($stock,$supID, $dose);

        while ($stmt->fetch()) {
          
          $stocks[] = $stock;
          $supIDs[] = $supID;
          $doses[] = $dose;
        } 
  
    include('closeDB.php');
    
    return ($stmt->num_rows> 0 ? array($stocks,$supIDs, $doses):-1);  
  } else {
    return -1;
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

//get Time allocated week
//Param -> week as int: int
function getWeekHours($week) {
  include('db.php');
  $week = $conn->real_escape_string($week);
  $userID = get_current_user_id();
  $sql = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(TillDateTime,FromDateTime))/3600)
  FROM usercalendar 
  WHERE UserID = $userID AND WEEK(usercalendar.FromDateTime)=".$week;

  if ($result = $conn->query($sql)) {  
      //GET DAY
      return round($result->fetch_row()[0],2);
  } else {
      return 0;
  }
}

//get cost of week
//Param -> week as int : int
function getWeekCost($week) {
  include('db.php');
  $userID = get_current_user_id();
  $week = $conn->real_escape_string($week);
  $sql = "SELECT SUM(protocolguide.Dosage *supplement.SupPrice)
  FROM usercalendar
  INNER JOIN protocolguide
  ON usercalendar.ProtID = protocolguide.ProtID
  INNER JOIN supplement
  ON protocolguide.SupID=supplement.SupID
  WHERE UserID =$userID AND WEEK(usercalendar.FromDateTime)=$week";

  if ($result = $conn->query($sql)) {  
      //GET DAY
      return $result->fetch_row()[0];
  } else {
      return 0;
  }
}
//get cost of experiment
//Param exp as int refers to calendarID
function getExperimentCost($exp) {
  include('db.php');
  $userID = get_current_user_id();
  $week = $conn->real_escape_string($week);
  $sql = "SELECT SUM(protocolguide.Dosage *supplement.SupPrice)
  FROM usercalendar
  INNER JOIN protocolguide
  ON usercalendar.ProtID = protocolguide.ProtID
  INNER JOIN supplement
  ON protocolguide.SupID=supplement.SupID
  WHERE UserID =$userID AND usercalendar.CalenID=$exp";

  if ($result = $conn->query($sql)) {  
      //GET DAY
      return $result->fetch_row()[0];
  } else {
      return 0;
  }
}




//getList of used chemicals
function getWeekSupplements($week) {
  include('db.php');
  $userID = get_current_user_id();
  $week = $conn->real_escape_string($week);
  $sql = "SELECT supplement.SupName,SUM(protocolguide.Dosage) as total
  FROM usercalendar
  INNER JOIN protocolguide
  ON usercalendar.ProtID = protocolguide.ProtID
  INNER JOIN supplement
  ON protocolguide.SupID=supplement.SupID
  WHERE UserID =$userID AND WEEK(usercalendar.FromDateTime)=$week
  GROUP BY supplement.SupName";

  if ($result = $conn->query($sql)) {  
      //GET DAY
      return $result->fetch_all(MYSQLI_ASSOC);
  } else {
      return 0;
  }
}

//INVENTORY

function getInventorySupplement($SupName) {
  include('db.php');
  $sql = "SELECT supplement.SupID,supplement.SupName,supplement.SupPrice,inventory.Amount 
  FROM inventory 
  INNER JOIN supplement
  ON inventory.SupID= supplement.SupID 
  WHERE inventory.LabID =". $_SESSION['lab']." AND supplement.SupName=  '$SupName' ";

  if ($result = $conn->query($sql)) {

    return $result->fetch_all(MYSQLI_ASSOC)[0];
  
    } else {
      return false;
  }
}



function supplementExists($SupName) {
  include('db.php');
  $sql = "SELECT SupName 
  From supplement
  WHERE SupName= '$SupName'";

  if ($result = $conn->query($sql)) {

     return ($result->num_rows ==1 ? true : false);
  
    } else {
      return false;
  }
}

//INSERT new Supplement param: supplement name & price. Returns last id (SupID) OR false 
function insertSupplement($SupName,$SupPrice) {
 

  if(supplementExists($SupName)) {
    
    return false;

  } else {

    include('db.php');
    $sql = "INSERT INTO supplement(SupName,SupPrice) VALUES ('$SupName', '$SupPrice')";
    $result = $conn->query($sql);

    return ($result ? $conn->insert_id : false);

    
  }

}

function getLabInventory($labID) {
  include('db.php');
  $sql =  'SELECT  supplement.SupName,supplement.SupPrice,inventory.Amount 
  FROM inventory
  INNER JOIN supplement ON inventory.SupID= supplement.SupID
  WHERE inventory.LabID ='. $_SESSION['lab'];

  
  if ($result = $conn->query($sql)) {  
      //GET DAY
      return $result->fetch_all(MYSQLI_ASSOC);
  } else {
      return 0;
  }
}
  


function printLabInventory($labID) {
    $result = getLabInventory($labID);

    foreach($result as $t) {

      ($t['Amount']<=50 ? $alert = "Running out of stock!" :$alert = ""); 

      printf('<tr>
                <td>%s</td>
                <td>%s</td>
                <td><span class="alert-red">%s</span></td>
              </tr>',$t['SupName'],$t['Amount'],$alert);
    } 

}

//Exists in inventory
function supplementExistsInventory($SupName) {
  include('db.php');
  $sql = "SELECT supplement.SupID
  FROM inventory 
  INNER JOIN supplement
  ON inventory.SupID= supplement.SupID 
  WHERE inventory.LabID =". $_SESSION['lab']." AND supplement.SupName=  '$SupName' ";

  if ($result = $conn->query($sql)) {
     
     return ($result->num_rows ==1 ? $result->fetch_assoc()['SupID'] : false);
  
    } else {
      return false;
  }
}


//insert supplement to inventory Returns true on succes false on failure
function insertToInventory($LabID,$SupID,$Amount) {
 
    include('db.php');

    $sql = "INSERT INTO Inventory(LabID,SupID,Amount) VALUES ('$LabID','$SupID','$Amount')";
    print($sql);
    $result = $conn->query($sql);

    return ($result ? true: false);

    
  }

  //getSupID
  function getSupID($SupName) {
    include('db.php');
    $sql = "SELECT supplement.SupID
    FROM supplement
    WHERE supplement.SupName= '$SupName' ";
  
    if ($result = $conn->query($sql)) {
       
       return ($result->num_rows ==1 ? $result->fetch_assoc()['SupID'] : false);
    
      } else {
        return false;
    }
  }

