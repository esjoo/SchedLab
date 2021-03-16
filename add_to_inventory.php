<?php
include_once('includes/functions.php');
//Error handling function
function amountError($errno, $errstr) {
    $_SESSION['error'] = "<b>Error: </b>. $errstr .<br>";
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

//set errror
$_SESSION['error'] = "";


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
            $_SESSION['error'] ='amount cannot be less than 0';
            header('Location: inventory.php');
            exit();
        }

    if($price!=$storedinformation['SupPrice'] && $price !="") {
        
        $conn->autocommit(FALSE); //turn on transactions  


        $sql1 = "UPDATE inventory SET Amount= '$new_amount'  WHERE inventory.LabID=". "'". $_SESSION['lab']  ."'"  . " AND inventory.SupID=". $storedinformation['SupID'];  
        $sql2 = "UPDATE supplement SET SupPrice= ".  $price . " WHERE SupID= ". $storedinformation['SupID'];   
        #UPDATE supplement SET SupPrice = 1 WHERE SupID = 12
        print($conn->query($sql1)==0);
        if(!$conn->query($sql2)) {
            print('A');
            print($sql1);
        } else {
            header('Location: inventory.php');
        }

        //END TRANSACTION
        $conn->autocommit(TRUE); //turn off transactions + commit queued queries
        print('A');
        print($sql2);
    } elseif($price==$storedinformation['SupPrice']) {

        $sql1 = "UPDATE inventory SET Amount= '$new_amount'  WHERE inventory.LabID=". "'". $_SESSION['lab']  ."'"  . " AND inventory.SupID=". $storedinformation['SupID']; 
        if(!$conn->query($sql1)) {
            print('B');
            print($sql1);
        } else {
            header('Location: inventory.php');
        }

        

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
