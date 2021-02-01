<?php 
if(isset($_POST['submit'])) {
    
    require_once('db.php');

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);

    $sql =  'SELECT id FROM  genres WHERE name =' . "\"". $genre . "\"";
    echo($sql);
    if (mysqli_query($conn, $sql)) {
        $result = mysqli_query($conn, $sql);
        $genreID = mysqli_fetch_assoc($result)['id'];
        echo($genreID);
    }  else {
        echo "New record created unsuccessfully";
    }
    
    $val = "\"".$name."\""   .','.  "\"".$year ."\"" .  ','  . "\"".$rating. "\"" .','. "\"".$genreID."\"";
    
   

    $sql = "INSERT INTO movies (name,year, rating, genre) VALUES(" .$val . ");";
   
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
