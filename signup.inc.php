<?php 
if(isset($_POST['submit'])) {
    require_once('db.php');
    # TODO: sanitise inputs 
    
    $username = '"'. mysqli_real_escape_string($conn,$_POST['username']) .'"';
    #$email = mysqli_real_escape_string($conn,$_POST['email']);
    $password ='"'. mysqli_real_escape_string($conn,$_POST['password']) .'"';

    $val = $username .','. $password;
    
    $sql = "INSERT INTO Users (Name, Pword) VALUES(" .$val . ");";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        header('Location: index.php');
        exit();
     } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
     }
} else {
    header('Location: index.php');
    exit;
    }   




?>