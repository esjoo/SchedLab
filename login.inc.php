<?php 
if(isset($_POST['submit'])) {
    
    require_once('db.php');
    # TODO
    $email = "'". mysqli_real_escape_string($conn, $_POST['email']) . "'";

    $password = "'". mysqli_real_escape_string($conn, $_POST['pwd']) . "'";

    # TODO
    $sql = "SELECT usersEmail, usersName 
    FROM users 
    WHERE usersPwd = $password AND usersPwd= $email"; 
    
    
    $query = mysqli_query($conn, $sql);

    $result = mysqli_fetch_assoc($query);

    # TODO
    if(empty(($result)) ) {   
        print_r($result);
        $_SESSION['userName'] = $result['userName'];
        header('Location: index.php');
        exit();
    } else {
        header('Location: index.php?=fail');
    }
}

    
    
    ?>
