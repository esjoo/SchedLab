<?php 
if(isset($_POST['submit'])) {
    
    require_once('db.php');

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $procedure = mysqli_real_escape_string($conn, $_POST['procedure']);
    $equipment = mysqli_real_escape_string($conn, $_POST['equipment']);
    $chemicals = mysqli_real_escape_string($conn, $_POST['chemical']);

    $val = "\"".$name."\""   .','.  "\"".$type ."\"" .  ','  . "\"".$procedure. "\"" .','. "\"".$equipment."\"" .  ','  . "\"".$chemicals. "\"";
   
    $sql = "INSERT INTO protocol (Name, Type, Procedure, AllEquipment, AllReagents) VALUES (".$val.");";
   
    echo($sql); 
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        header('Location: ../index.php');
        exit();
     } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
     }  
    } 
?>
