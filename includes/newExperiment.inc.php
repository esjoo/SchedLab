<?php 
if(isset($_POST['submit'])) {
    include_once('functions.php');
    # TODO: sanitise inputs 
    chdir('../'); // DUMB BUT WORKS?
    include('db.php');
    $protocolName = $_POST['protocolName'];

    $labtimeStart =date('Y-m-d G:i:s', strtotime($_POST['labtimeStart'])); 
    $labtimeEnd = date('Y-m-d G:i:s', strtotime($_POST['labtimeEnd']));


    //fetch protocolID
    $protID = get_protocolID($protocolName);
    // TRY
    
    try {
        
        $conn->autocommit(FALSE); //turn on transactions
        
        $res=getInventory($protID);
        if(checkInventory($res[0],$res[1])) { //SUCCESS
            
            //sql
            $sql1 = "INSERT INTO usercalendar (UserID,ProtID,FromDateTime,TillDateTime) VALUES(?,?,?,?)"; //INSERT INTO USERCALENDAR
            $sql2 = "INSERT INTO Experiment (CalenID,ProtID,UserID) VALUES(?,?,?)"; //INSERT EXPERIMENT
            $sql3 = "UPDATE inventory SET Amount= Amount-? WHERE SupID=? AND UserID=?";  //UPDATE INVENTORY          
            
            // PREP
            $stmt1 = $conn->prepare($sql1);     //INSERT INTO USERCALENDAR
            $stmt2 = $conn->prepare($sql2);     //INSERT EXPERIMENT
            $stmt3 = $conn->prepare($sql3);     //UPDATE INVENTORY
            
            // BIND
            $stmt1->bind_param("ssss",$_SESSION['userID'],$protID,$labtimeStart,$labtimeEnd);  //INSERT INTO USERCALENDAR
            $stmt2->bind_param("sss",$calenID,$protID,$_SESSION['userID']);                    //INSERT EXPERIMENT
            $stmt3->bind_param("sss",$amount,$sup,$_SESSION['userID']);             //UPDATE INVENTORY
            
            //EXECUTE
            if(!$stmt1->execute()) {
                throw new Exception($conn->error);
            }
            $calenID = $conn->insert_id; 
            if(!$stmt2->execute()) {
                throw new Exception($conn->error);
            }

            //UPDATE INVENTORY
            $j =count($res[0]);
            for($i=0; $i<$j; $i++) {
                $amount = $res[2][$i];
                $sup = $res[1][$i];
                if(!$stmt3->execute()) {
                    throw new Exception($conn->error);
                }
            }          

            
        }
            

            //END TRANSACTION
             $conn->autocommit(TRUE); //turn off transactions + commit queued queries
        
}catch(Exception $e) {
    $mysqli->rollback(); //remove all queries from queue if error (undo)
}
//non current week is set
if(isset($_GET['w'])) {
    header('Location: ../index.php?w='.$_GET['w']);
} else {
    header('Location: ../index.php');
}
//current week

} else {
    #accessed this file without submiting form
    header('Location: ../index.php?state=R');
    exit;
    }   