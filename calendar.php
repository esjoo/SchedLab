<!-- calendar window-->
<div class="row h-100 flex-nowrap">
  <!-- column Time wrapper -->
  <div class= "d-flex flex-column border border-dark">
    <!-- header-->
    <div class="p-2 border border-dark "> Time </div>
    <!-- content -->
    <?php 
    #$hours = range(0,24);
    
    foreach (range(8,17) as $hour) {
      $active='';
      if($hour == localtime(time(),TRUE)['tm_hour']){
        $active = 'bg-primary';
      }
      printf('<div class="col border border-dark flex-grow-1 %s"> %s:00 </div>',$active,$hour);
    }
    ?>
  </div>
       <?php
       
    $tmpContent =array( "Analyzing biological data to produce meaningful information involves writing and.",
    "Before sequences can be analyzed they have to be obtained from the data storage bank example the Genbank.",
     "This process needs to be automated because most genomes are too large to annotate by hand, not to mention the desire to annotate as many genomes as possible, as the rate of sequencing has ceased to pose a bottleneck. Annotation is made possible by the fact that genes have recognisable start and stop regions, although the exact sequence found in these regions can vary between genes.");

    $startTime = 1613972301;
    $endTime = 	1613982311;
    $trgButton = dateTimeToElement($startTime,$endTime)/(17-8)*100 . '%'; 
    $protocolHeader = 'HEADER OF EXPERIMENT GOES HERE';
    
    for ($i = 1; $i<=7; $i++) {	
      $active = 'bg-secondary';
      //Check which day
      if(date_format(date_create(),'l jS') == date_format( $day,'l jS')) {
        $active = 'bg-primary';
      }	
      //day wrapper
      $bg = '';
      echo('<div class ="col p-0 border border-dark weekday"  style="background: url("gfx/T.png") background-repeat:repeat-y" >'); 
      //print header
      printf('<div class=" p-2 border border-dark  %s"> %s </div>',$active,date_format( $day,'l jS') );

      // print content
      foreach($tmpContent as $protocolContent) {
        printf('
        <div class="btn btn-primary col mb-1 mr-1 day" data-toggle="modal" data-target="#exampleModal" data-protocolHead=" %s" data-protocolContent="%s" style="height:%s">%s</div>
        ',$protocolHeader,$protocolContent,$trgButton,$protocolHeader);
      }
      
      //close day wrapper
      printf('</div>');
      // Increment day
			$day = date_modify($day,"1 days");
		}

    include('experimentModal.php');
    ?>

  </div>