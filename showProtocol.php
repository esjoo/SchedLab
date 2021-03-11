<!DOCTYPE html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style/protocol.css">
</head>

<body style="background-color:#FBF3F3;">
    <?php 
        include 'header.php';
        include "db.php";

        $protName = $_POST['protName'];
        $procedure = $_POST['procedure'];
        $equipment = $_POST['equipment'];
        $chemicals = $_POST['chemicals'];
        $dosages = $_POST['dosages'];
        $ProtCreater = $_POST['ProtCreater'];
 
        include "closeDB.php";
    ?>

    <div>
        <div class="color">
            <h5 style="opacity:0">Name</h5>
            <h4>Protocol Name</h4>
                <div class="part">
                    <?php
                        echo "<div>{$protName}</div>";
                    ?>
                </div>

            <h4>Procedure</h4> 
                <div class="part">
                    <?php
                        $procedure = nl2br($procedure, true);

                        echo "<div>{$procedure}</div>";
                    ?>
                </div>

            <h4>Equipment</h4>
                <div class="part">
                    <?php
                        $equipment = nl2br($equipment, true);
            
                        echo "<div>{$equipment}</div>";
                    ?>
                </div>

            <h4>Chemical</h4>
                <div class="center">
                    <?php
                        echo '<table width="50%">';
                        echo '<tr>
                                <th>Chemical</th>
                                <th>Dosage</th>
                            </tr>';
                        
                        $cheLen = count($chemicals);
                        for($i=0;$i<$cheLen;$i++){
                            $c = $chemicals[$i];
                            $d = $dosages[$i];
                            echo "<tr>
                                    <td>{$c}</td>
                                    <td>{$d}</td>
                                </tr>";
                        };

                        echo "</table>";

                    ?>
                </div>
    
        <div class="form-inline">
            <form action="" method='post' onsubmit="return checkName()">
                
                <?php
                    // check if there is a same protocol name in the db.
                    include 'db.php';
                    $result = mysqli_query($conn,"SELECT ProtName FROM Protocols WHERE ProtName = '$protName'");
                    $num1 = mysqli_num_rows($result);
                    if($num1 == '0'){
                        echo '<input type="hidden" id="test1" name="test1" value="0">';
                    }else{
                        echo '<input type="hidden" id="test1" name="test1" value="1">';
                    }
                    include 'closeDB.php';

                ?>

                <input type="hidden" name="protName" value="<?php echo $protName?>">
                <input type="hidden" name="ProtCreater" value="<?php echo $ProtCreater?>">
                <input type="hidden" name="procedure" value="<?php echo strip_tags($procedure, true)?>">
                <input type="hidden" name="equipment" value="<?php echo strip_tags($equipment, true)?>">

                <?php
                    $len = count($chemicals);
                    for($i=0;$i<$len;$i++){
                        echo '<input type="hidden" name="chemicals[]" value="' . $chemicals[$i] . '">';
                        echo '<input type="hidden" name="dosages[]" value="' . $dosages[$i] . '">';
                    }
                ?>

                
                <button name="submit1" type="submit" class="button" style="width: 200px"><span>Submit</span></button>
                
            </form>

            <form action="editProtocol.php" method='post'>
                <input type="hidden" name="protName" value="<?php echo $protName?>">
                <input type="hidden" name="procedure" value="<?php echo $procedure?>">
                <input type="hidden" name="equipment" value="<?php echo $equipment?>">
                
                <?php
                    $len = count($chemicals);
                    for($i=0;$i<$len;$i++){
                        echo '<input type="hidden" name="chemicals[]" value="' . $chemicals[$i] . '">';
                        echo '<input type="hidden" name="dosages[]" value="' . $dosages[$i] . '">';
                    }
                ?>

                <div>

                    <?php
                        $userName = $_SESSION['userName'];
                        echo '<input type="hidden" name="ProtCreater" value="' . $userName . '">';
                        if ($userName == $ProtCreater){
                            echo '<button name="submit2" type="submit" class="button" style="width: 200px"><span>Edit</span></button>';
                        }else{
                            echo '<button name="submit2" type="submit" class="button" style="width: 200px"><span>Copy</span></button>';
                        }
                    ?>
                    
                </div>
            </form>
        </div>
    </div>
    <h5 style="opacity:0">Name</h5>
</div>

<!-- send form to insert.inc.php -->
<script language="javascript">
function checkName(){
    var protTest1 = $('#test1').val()
    if(protTest1 == 1){
        alert('Protocol name already exists, please change!')
        return false;
    }else{
        return true;
    }
}
</script>

</html>

<!-- submit the form -->
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
        echo "<script>alert('Successfully enter a new protocol!')</script>";
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










