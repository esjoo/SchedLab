<?php 
if(isset($_POST['submit'])) {
    
    include('db.php');

    // insert the protocol into the database
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    $procedure = mysqli_real_escape_string($conn, $_POST['procedure']);
    $equipment = mysqli_real_escape_string($conn, $_POST['equipment']);

    $sql1 = "INSERT INTO protocols (ProtName, ProtMethod, EquipmentID) 
    VALUES ('$name', '$procedure','$equipment')";

    if ($conn->query($sql1) === TRUE) {
        echo "Successfully enter a new protocol!";
    } else {
        echo "Error: " . $sql1 . "<br>" . $conn->error;
    }


    // insert the amount of chemicals have been in db into the ProtocolGuid db
    $chemicals = $_POST['chemicals'];
    $dosages = $_POST['dosages'];

    $sql2 = "INSERT INTO ProtocolGuide (Dosage, ProtID, SupID)  VALUES(?, ?, ?)"; 
    $stmt = mysqli_stmt_init($conn);
 
    if (mysqli_stmt_prepare($stmt, $sql2)) {        
        mysqli_stmt_bind_param($stmt, 'iii', $Dosage, $ProtID, $SupID);

        $length = count($dosages);
        $ProtID0 = mysqli_query($conn,"SELECT * FROM Protocols WHERE ProtName = '$name'");

        while($row = $ProtID0->fetch_assoc()){
            $ProtID = $row['ProtID'];
        }

        for ($i=0; $i < $length; $i++)
        {
            $Dosage = $dosages[$i];           
            $SupID0 = mysqli_query($conn,"SELECT * FROM Supplement WHERE SupName = '$chemicals[$i]'");
            
            while($row = $SupID0->fetch_assoc()){
                $SupID = $row['SupID'];
            }

            mysqli_stmt_execute($stmt);
        }
    }


    // insert the amount of chemicals haven't been in db into the ProtocolGuid db and Supplement db
    $NEWchemicals = $_POST['NEWchemicals'];
    $NEWdosages = $_POST['NEWdosages'];

    //// firstly, insert these new chemicals into Supplement
    $sql3 = "INSERT INTO Supplement (SupName, SupPrice, Stock)  VALUES(?, ?, ?)"; 
    $stmt1 = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt1, $sql3)) {
        mysqli_stmt_bind_param($stmt1, 'sss', $SupName, $SupPrice, $Stock);

        $length = count($NEWchemicals);
        $SupPrice = 0;
        $Stock = 0;
        for ($i=0; $i < $length; $i++)
        {
            $SupName = $NEWchemicals[$i];           
            mysqli_stmt_execute($stmt1);
        }
    }

    /// then, insert them into ProtocolGuid
    $stmt2 = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt2, $sql2)) {        
        mysqli_stmt_bind_param($stmt2, 'sss', $Dosage, $ProtID, $SupID);

        $length1 = count($NEWdosages);
        $ProtID0 = mysqli_query($conn,"SELECT * FROM Protocols WHERE ProtName = '$name'");
        while($row = $ProtID0->fetch_assoc()){
            $ProtID = $row['ProtID'];
        }

        for ($i=0; $i < $length1; $i++)
        {
            $Dosage = $NEWdosages[$i];           
            $SupID0 = mysqli_query($conn,"SELECT * FROM Supplement WHERE SupName = '$NEWchemicals[$i]'");
            while($row = $SupID0->fetch_assoc()){
                $SupID = $row['SupID'];
            }
            mysqli_stmt_execute($stmt2);
        }
    }

    
}

include "closeDB.php"

?>
