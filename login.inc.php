<?php 
if(isset($_POST['submit'])) {
    
    require_once('db.php');
    # TODO
    $name = "'". mysqli_real_escape_string($conn, $_POST['name']) . "'";

    $password = "'". mysqli_real_escape_string($conn, $_POST['pwd']) . "'";

    # TODO
    $sql = "SELECT Name, Pword 
    FROM Users 
    WHERE Pword = $password AND Name = $name"; 
    
    
    $query = mysqli_query($conn, $sql);

    
    $result = mysqli_fetch_array($query);

    # TODO
    if(mysqli_num_rows($query) > 0) {   
        session_start();
        $_SESSION['userName'] = $result['Name'];
        $_SESSION['loggedIn'] = TRUE;
        print($_SESSION['userName']);

        mysqli_free_result($query);
        include 'closeDB.php'; 
        header('Location: index.php');
    } else {
        echo'FAILED';
        header('Location: index.php?=fail');
    }
}

    
    
    ?>
