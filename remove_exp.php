<?php
include('includes/functions.php');
include("db.php");

$calenID = $_GET['cali'];



// check TIME



$protID = get_protocolID(htmlspecialchars($_GET["p"]));
print('P'.$protID);

try {
    
    $conn->autocommit(FALSE); //turn on transactions
    
    $res=getInventory($protID);

        print_r($res);
        //sql
        $sql1 = "UPDATE inventory SET Amount= Amount+? WHERE SupID=? AND LabID=?";  //UPDATE INVENTORY  
        $sql2 = "DELETE FROM Experiment WHERE CalenID = ?"; //DELETE EXPERIMENT
        $sql3 = "DELETE FROM UserCalendar WHERE CalenID = ?"; //DELETE USERCALENDAR
        
        
        // PREP
        $stmt1 = $conn->prepare($sql1);     //UPDATE INVENTORY
        $stmt2 = $conn->prepare($sql2);     //DELETE EXPERIMENT
        $stmt3 = $conn->prepare($sql3);     //DELETE USERCALENDAR
        
        // BIND
        $stmt1->bind_param("sss",$amount,$sup,$_SESSION['userID']); //UPDATE INVENTORY 
        $stmt2->bind_param("s",$calenID);                    //DELETE EXPERIMENT
        $stmt3-> bind_param("s",$calenID);         //DELETE USERCALENDAR
        
        //UPDATE INVENTORY
        $j =count($res[0]);
        for($i=0; $i<$j; $i++) {
            $amount = $res[2][$i];
            $sup = $res[1][$i];
            if(!$stmt1->execute()) {
                print 'A';
                throw new Exception($conn->error);
            }
        }  
        
        
        //EXECUTE
        if(!$stmt2->execute()) {
            throw new Exception($conn->error);
            print 'B';
            exit;
        }
        if(!$stmt3->execute()) {
            print 'C';
            throw new Exception($conn->error);
            exit;
        }
        
        
        
        
   
}catch(Exception $e) {
    echo $e;
    $conn->rollback(); //remove all queries from queue if error (undo)
    throw $e;
}

print_r(getInventory($protID));
//END TRANSACTION
$conn->autocommit(TRUE); //turn off transactions + commit queued queries

include("closedb.php");

//non current week is set
if(isset($_GET['w'])) {
    header('Location: ../index.php?w='.$_GET['w']);
   
} else {
    header('Location: ../index.php');
}

?>