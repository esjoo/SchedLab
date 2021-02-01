<?php 
include('db.php');
	# TODO
    #Return the whole DB
    $sql = 'SELECT movies.name, genres.name, movies.rating, movies.year 
    FROM movies
    LEFT JOIN genres ON movies.genre = genres.id';
  

    if(mysqli_query($conn, $sql)) {
        $result = mysqli_query($conn, $sql);
    } else {
        echo('FAIL:'. mysqli_connect_error());
}
?>

<table class="table table table-hover table-bordered">
    <thead class="thead-dark">
      <tr>
	  	<th>Time</th>
		<?php
		if(!isset($_GET['week'])) {
			$day =(strtotime("Monday"));
		}

		for ($i = 1; $i<=7; $i++) {
			#$start =date_add($start,date_interval_create_from_date_string('1 days'));
			
			printf('<th>%s</th>',date('l jS', $day) );
			$day = strtotime("+$i day");
		}
		
		

		?>

      </tr>
    </thead>
    <tbody>
      <tr>
        <?php 
        while($row = mysqli_fetch_row($result)){
        
           printf('
		   <tr>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
           </tr>',$row[0],$row[1],$row[2],$row[3],'empty','empty','empty','empty','empty'
        );
        }
        ?>
    </tbody>
  </table>