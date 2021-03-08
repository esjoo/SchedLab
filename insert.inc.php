<!-- Now, users can submit protocol in showProtocol.php, so, this file is useless -->

<?php 
if(isset($_POST['submit1'])) {

    include('db.php');

    // insert the protocol into the database
    $protName = mysqli_real_escape_string($conn, $_POST['protName']);
    $procedure = mysqli_real_escape_string($conn, $_POST['procedure']);
    $equipment = mysqli_real_escape_string($conn, $_POST['equipment']);
    $ProtCreater = $_POST['ProtCreater'];


    $sql = "INSERT INTO protocols (ProtName, ProtMethod, EquipmentID, Creater) 
    VALUES ('$protName', '$procedure','$equipment','$ProtCreater')";

    if ($conn->query($sql) === TRUE) {
        echo "Successfully enter a new protocol!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


    // insert the amount of chemicals have been in db into the ProtocolGuid db
    $chemicals = $_POST['chemicals'];
    $dosages = $_POST['dosages'];

    $sql1 = "INSERT INTO Supplement (SupName, SupPrice, Stock)  VALUES(?, ?, ?)"; 
    $stmt1 = mysqli_stmt_init($conn);

    $sql2 = "INSERT INTO ProtocolGuide (Dosage, ProtID, SupID)  VALUES(?, ?, ?)"; 
    $stmt2 = mysqli_stmt_init($conn);

    $ProtID0 = mysqli_query($conn,"SELECT * FROM Protocols WHERE ProtName = '$protName'");
    while($row = $ProtID0->fetch_assoc()){
        $ProtID = $row['ProtID'];
    }

    $length = count($chemicals);
    for($i=0;$i<$length;$i++){
        $chemical = $chemicals[$i];
        $result = mysqli_query($conn,"SELECT SupName FROM Supplement WHERE SupName = '$chemical'");
        $num = mysqli_num_rows($result);
        
        if($num == "0"){
            if (mysqli_stmt_prepare($stmt1, $sql1)) {
                mysqli_stmt_bind_param($stmt1, 'sii', $SupName, $SupPrice, $Stock);               
                $SupPrice = 0;
                $Stock = 0;               
                $SupName = $chemical;           
                mysqli_stmt_execute($stmt1);               
            }
        }

        if (mysqli_stmt_prepare($stmt2, $sql2)) {        
            mysqli_stmt_bind_param($stmt2, 'iii', $Dosage, $ProtID, $SupID);           
            $Dosage = $dosages[$i];           
            $SupID0 = mysqli_query($conn,"SELECT * FROM Supplement WHERE SupName = '$chemical'");
            while($row = $SupID0->fetch_assoc()){
                $SupID = $row['SupID'];
            }
            mysqli_stmt_execute($stmt2);
        }
    }
    include 'closeDB.php';
}
?>
