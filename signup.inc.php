<?php 
if(isset($_POST['submit'])) {
    require_once('db.php');
    # TODO: sanitise inputs 
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $val = "\"". $username . "\"". ',' . "\"". $email . "\"" .',' . "\"". $password ."\"";
    
    $sql = "INSERT INTO users (usersName,usersEmail, usersPwd) VALUES(" .$val . ");";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        header('Location: ../index.php');
        exit();
     } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
     }
} else {
    header('Location: ../index.php');
    exit;
    }   




?>