<?php 
include('includes/functions.php');
/*include('db.php');
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
  include('closeDB.php'); */
?>
<!-- calendar window-->
<div class="row h-100">
  <!-- column Time wrapper -->
  <div class= "d-flex flex-column border border-dark">
    <!-- header-->
    <div class="p-2 border border-dark "> Time </div>
    <!-- content -->
    <?php 
    #$hours = range(0,24);
   
    foreach (range(8,17) as $hour) {
      printf('<div class="col border border-dark bg-primary flex-grow-1"> %s:00 </div>',$hour);
    }
    ?>
  </div>
       <?php
       
    $tmpContent =array( "Analyzing biological data to produce meaningful information involves writing and.",
    "Before sequences can be analyzed they have to be obtained from the data storage bank example the Genbank.",
     "This process needs to be automated because most genomes are too large to annotate by hand, not to mention the desire to annotate as many genomes as possible, as the rate of sequencing has ceased to pose a bottleneck. Annotation is made possible by the fact that genes have recognisable start and stop regions, although the exact sequence found in these regions can vary between genes.");

    $trgButton = dateTimeToElement(1613972301,1613986759); 
    $protocolHeader = 'HEADER OF EXPERIMENT GOES HERE';
    $startTime = 8;
    $endTime = 12;
    for ($i = 1; $i<=7; $i++) {	
      $active = 'bg-secondary';
      //Check which day
      if(date_format(date_create(),'l jS') == date_format( $day,'l jS')) {
        $active = 'bg-primary';
      }	
      //day wrapper
      $bg = '';
      echo('<div class ="col p-0 border border-dark "  style="background: url("gfx/T.png") repeat-y" >'); 
      //print header
      printf('<div class=" p-2 border border-dark  %s"> %s </div>',$active,date_format( $day,'l jS') );

      // print content
      foreach($tmpContent as $protocolContent) {
        printf('
        <div class="btn btn-primary col py-%s mb-1 mr-1" data-toggle="modal" data-target="#exampleModal" data-protocolHead=" %s" data-protocolContent=" %s" >%s</div>
        ',$trgButton,$protocolHeader,$protocolContent,$protocolHeader);
      }
      
      //close day wrapper
      printf('</div>');
      // Increment day
			$day = date_modify($day,"1 days");
		}

    include('experimentModal.php');
    ?>

  </div>