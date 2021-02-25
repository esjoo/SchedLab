<?php 
if(isset($_POST['submit'])) {
    require_once('../db.php');
    # TODO: sanitise inputs 
    $user = mysqli_real_escape_string($conn,$_POST['username']);
    $fname = mysqli_real_escape_string($conn,$_POST['fname']);
    $lname = mysqli_real_escape_string($conn,$_POST['lname']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);

    $password = password_hash( mysqli_real_escape_string($conn,$_POST['password']),PASSWORD_DEFAULT);

    $stmt = mysqli_stmt_init($conn);
    $sql = "INSERT INTO Users (UserName,UserFirstName,UserLastName,UserPassword,UserEmail) VALUES(?,?,?,?,?)";
    if($stmt =mysqli_prepare($conn, $sql)) {
        
        mysqli_stmt_bind_param($stmt, "sssss",$user,$fname,$lname,$password,$email);
        mysqli_stmt_execute($stmt);


        echo "New record created successfully";
        require_once('../closeDB.php');

        header('Location: ../index.php');
        
    } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
    }

} else {
    #accessed this file without submiting form
    header('Location: ../index.php?state=R');
    exit;
    }   




?>