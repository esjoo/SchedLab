<?php 

include('db.php');
    $sql = "SELECT UserName
    FROM Users"; 

    $stmt = mysqli_stmt_init($conn);
    if($stmt =mysqli_prepare($conn, $sql)) {

        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$result);
        mysqli_stmt_store_result($stmt);
    }
    
    
    while(mysqli_stmt_fetch($stmt)) {
        $dbNames[] = $result;
    }

include('closeDB.php');

