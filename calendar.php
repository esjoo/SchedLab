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
		for ($i = 1; $i<=7; $i++) {	
      $active = '';
      if( date_format(date_create(),'l jS') == date_format( $day,'l jS')) {
        $active = 'bg-primary';
      }	
			printf('<th class="%s"> %s </th>',$active,date_format( $day,'l jS') );
			$day = date_modify($day,"1 days");
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