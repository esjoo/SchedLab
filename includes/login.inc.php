<?php 
if(isset($_POST['submit'])) {
    
    require_once('../db.php');
    # TODO
    $name = mysqli_real_escape_string($conn, $_POST['userName']);

    $password =mysqli_real_escape_string($conn, $_POST['pwd']);

    # TODO
    $sql = "SELECT UserName, UserPassword, UserType, UserID, lab, UserFirstName
    FROM users 
    WHERE UserName = ?"; 

    $stmt = mysqli_stmt_init($conn);
    if($stmt =mysqli_prepare($conn, $sql)) {

        mysqli_stmt_bind_param($stmt, "s",$name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$dbName,$dbhash,$isAdmin,$userID,$lab,$UserfirstName);
        mysqli_stmt_store_result ($stmt);
    }
    
    $result = mysqli_stmt_fetch($stmt);
 

    # TODO
    if(password_verify($password,$dbhash))  {   
        session_start();
        $_SESSION['userName'] = $dbName;
        $_SESSION['userFirstName']= $UserfirstName;        
        
        $_SESSION['loggedIn'] = TRUE;
        $_SESSION['isAdmin'] = $isAdmin;
        $_SESSION['userID'] = $userID;

        $_SESSION['lab'] = $lab;
        mysqli_stmt_close($stmt);
        include '../closeDB.php'; 
        header('Location: ../index.php?state=L');
    } else {
        header('Location: ../index.php?state=F');
    }
} else {
    #accessed this file without submiting form
    header('Location: ../index.php');
}

    
    
    ?>
