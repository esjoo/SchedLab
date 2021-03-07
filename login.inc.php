<?php 
if(isset($_POST['submit'])) {
    
    require_once('db.php');
    # TODO
    $email = "'". mysqli_real_escape_string($conn, $_POST['email']) . "'";

    $password = "'". mysqli_real_escape_string($conn, $_POST['pwd']) . "'";

    # TODO
    $sql = "SELECT usersEmail, usersName 
    FROM users 
    WHERE usersPwd = $password AND usersEmail= $email"; 
    
    
    $query = mysqli_query($conn, $sql);

    $result = mysqli_fetch_array($query);

    # TODO
    if(mysqli_num_rows($query) > 0) {   
        session_start();
        $_SESSION['userName'] = $result['usersName'];
        $_SESSION['loggedIn'] = TRUE;
        print($_SESSION['userName']);
        #eader('Location: index.php');
        #exit();
    } else {
        echo'FAILED';
        header('Location: index.php?=fail');
    }
}

    
    
    ?>
