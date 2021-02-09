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

<div class="d-flex flex-row align-self-stretch">
   		<?php
    $tmpContent = "
    <li>Analyzing biological data to produce meaningful information involves writing and running software programs that use algorithms from graph theory, artificial intelligence, soft computing, data mining, image processing, and computer simulation. The algorithms in turn depend on theoretical foundations such as discrete mathematics, control theory, system theory, information theory, and statistics.</li>

<li>Before sequences can be analyzed they have to be obtained from the data storage bank example the Genbank. DNA sequencing is still a non-trivial problem as the raw data may be noisy or afflicted by weak signals. Algorithms have been developed for base calling for the various experimental approaches to DNA sequencing.</li>

<li>In the context of genomics, annotation is the process of marking the genes and other biological features in a DNA sequence. This process needs to be automated because most genomes are too large to annotate by hand, not to mention the desire to annotate as many genomes as possible, as the rate of sequencing has ceased to pose a bottleneck. Annotation is made possible by the fact that genes have recognisable start and stop regions, although the exact sequence found in these regions can vary between genes.</li>";
    for ($i = 1; $i<=7; $i++) {	
      $active = 'bg-secondary';
      //Check which day
      if(date_format(date_create(),'l jS') == date_format( $day,'l jS')) {
        $active = 'bg-primary';
      }	
      //day wrapper
      echo('<div class ="col p-0 " >'); 
      //print header
      printf('<div class="p-2 border border-dark  %s"> %s </div>',$active,date_format( $day,'l jS') );

      // print content
      printf('<div class="p-2 "> %s </div></div>',$tmpContent);
      
      //close dive
      //printf('</div');
      // Increment day
			$day = date_modify($day,"1 days");
		}
    ?>

  </div>