<?php 
if(isset($_POST['submit'])) {
    require_once('../db.php');
    session_start();    
    # TODO: sanitise inputs 

    $protocolName = mysqli_real_escape_string($conn,$_POST['protocolName']);

    $labtimeStart = mysqli_real_escape_string($conn,date('Y-m-d G:i:s', strtotime($_POST['labtimeStart']))); 
    $labtimeEnd = mysqli_real_escape_string($conn,date('Y-m-d G:i:s', strtotime($_POST['labtimeEnd'])));


    //get protocolID from input name
    $sql =  'SELECT protID FROM  protocols WHERE ProtName =?';
    $stmt = mysqli_stmt_init($conn);

    if($stmt =$conn->prepare($sql)) {

        $stmt->bind_param("s",$protocolName);
        mysqli_stmt_execute($stmt);
        $stmt->bind_result($protID);
        $protID = $stmt->fetch();
        $stmt->close();
    }


/*
    // IF inventory checksout Insert ELSE THROW
   if(checkInventory()) {
       
   }
*/
    //Insert
    $sql = "INSERT INTO usercalendar (UserID,ProtID,FromDateTime,TillDateTime) VALUES(?,?,?,?)";
    if($stmt = $conn->prepare($sql)) {
        
        $stmt->bind_param("ssss",$_SESSION['userID'],$protID,$labtimeStart,$labtimeEnd);
        $stmt->execute();
        print_r( $stmt);

        echo "New record created successfully";
        require_once('../closeDB.php');

        header('Location: ../index.php');
        
    } else {       
      

        echo "Error: " . $sql .
        '<br>'. 
        $conn->errno.
        $conn->error.'<br>'.
        $stmt->errno.
        $stmt->error;
        
    }

} else {
    #accessed this file without submiting form
    header('Location: ../index.php?state=R');
    exit;
    }   