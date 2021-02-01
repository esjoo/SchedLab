<?php 
include('db.php');

if(isset($_POST['submit'])) {
    $sql = 'SELECT movies.name, genres.name, movies.rating, movies.year 
    FROM movies 
    LEFT JOIN genres ON movies.genre = genres.id
    AND movies.name='. "\"". $_POST['search'] ."\"";
    
} else { 
    $sql = 'SELECT movies.name, genres.name, movies.rating, movies.year 
    FROM movies
    LEFT JOIN genres ON movies.genre = genres.id';
}
  

    if(mysqli_query($conn, $sql)) {
        $result = mysqli_query($conn, $sql);
        include('closeDB.php');
        header('Location: showmovies.php');
        exit();
        
    } else {
        echo('FAIL:'. mysqli_connect_error());
}

?>