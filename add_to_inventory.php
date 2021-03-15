<?php
include_once('includes/functions.php');
//Error handling function
function amountError($errno, $errstr) {
    echo "<b>Error: </b> $errstr<br>";
    die();
}

//Set error handler
set_error_handler("amountError", E_USER_WARNING);


include_once("db.php");
$chemical_name=$_POST["chemical_name"];
$chemical_name=mysqli_real_escape_string($conn,$chemical_name);
$amount=$_POST["amount"];
$amount=mysqli_real_escape_string($conn,$amount);
$amount = intval($amount);

$price = mysqli_real_escape_string($conn,$_POST["price"]);
$price = intval($price);




if($existed =supplementExists($chemical_name)) {
    //get supplement
    if($SupID=supplementExistsInventory($chemical_name)) {
        $storedinformation = getInventorySupplement($chemical_name);
        $new_amount = $storedinformation['Amount']+$amount;
    } else {
        $SupID = getSupID($chemical_name);
        insertToInventory($_SESSION['lab'],$SupID,0);
        $new_amount = $amount;
        $storedinformation = getInventorySupplement($chemical_name);
    }


    if($new_amount<0) {
        echo 'FAILED';
        exit('FAILED');
        }

    if($price!=$storedinformation['SupPrice'] && $price !="") {
        
        $conn->autocommit(FALSE); //turn on transactions  


        $sql1 = "UPDATE inventory SET Amount= '$new_amount'  WHERE inventory.LabID=". "'". $_SESSION['lab']  ."'"  . " AND inventory.SupID=". $storedinformation['SupID'];  
        $sql2 = "UPDATE supplement SET SupPrice= ".  $price . " WHERE SupID= ". $storedinformation['SupID'];   
        #UPDATE supplement SET SupPrice = 1 WHERE SupID = 12
        print($conn->query($sql1)==0);
        $conn->query($sql2);

        //END TRANSACTION
        $conn->autocommit(TRUE); //turn off transactions + commit queued queries
        print('A');
        print($sql2);
    } elseif($price==$storedinformation['SupPrice']) {

        $sql1 = "UPDATE inventory SET Amount= '$new_amount'  WHERE inventory.LabID=". "'". $_SESSION['lab']  .'"'  . " AND inventory.SupID=". $storedinformation['SupID']; 
        $conn->query($sql1);
        print('B');

    } else {
        try {
            print('C');
                $conn->autocommit(FALSE); //turn on transactions  

                $supID = insertSupplement($chemical_name,$price);

                if($amount>=0) {
                    if(!insertToInventory($_SESSION['lab'],$supID,$amount)) {
                        throw new Exception($conn->error);
                    }
                } else {
                    if(!insertToInventory($_SESSION['lab'],$supID,0)) {
                        throw new Exception($conn->error);
                    }
                    
                }
            
            //END TRANSACTION
             $conn->autocommit(TRUE); //turn off transactions + commit queued queries
        
        }catch(Exception $e) {
            $conn->rollback(); //remove all queries from queue if error (undo)
            header('Location: inventory.php');
        }
    }
}
//Check IF $chemical_name exist in supplemnents

    //IF true 

        //CHECK IF newAmmount>0 && price!=storedprice && price!=""
            //START TRANSACTION 
            // Update inventory( Ammount) WHERE LABID & NAME <3
             // Uppdate supplement(price) SUPID ==$supID
             //END TRANSACTION

        //CHECK IF newAmmount>0 && price==storedprice && price!=""

        
        //CHECK IF price!=storedprice && price!=""
                        //Update inventory (Ammount)
        //ELSE?
             //Throw Error SUPP TOO LOW

            
    //IF FALSE
        //START TRANSACTION
        //INSERT INTO supplement
        //Get Id
        //INSERT INTO inventory with id
        //END TRANSACTION
    
    
// Add action to log

include_once('db.php');
$userID = get_current_user_id();

if ($existed) {
    $action = "Changed the amount of " . $chemical_name . " to " . $new_amount . " ml in inventory";
    $timestamp = date("Y-m-d G:i:s");
    $sql = "INSERT INTO logs(UserAction, Timestamp, Action) VALUES ($userID, '$timestamp', '$action')";
    $result = mysqli_query($conn, $sql);
} else {
    $action = "Added " . $amount . " ml of " . $chemical_name . " to inventory";
    $timestamp = date("Y-m-d G:i:s");
    $sql = "INSERT INTO logs(UserAction, Timestamp, Action) VALUES ($userID, '$timestamp', '$action')";
    $result = mysqli_query($conn, $sql); 
}

?>
