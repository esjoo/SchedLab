<link rel="stylesheet" href="style/calendar.css">


<!-- calendar window-->
<div class="box"  id="calendar">
	<!-- column Time wrapper -->
	<div class= "d-flex flex-column border-right">
		<!-- header-->
		<div class="p-2 border-bottom bg-secondary" style="background-color:#ddd"> Time </div>
		<!-- content -->
		<?php
		foreach (range(8,17) as $hour) {
		$active='';
		if($hour == localtime(time(),TRUE)['tm_hour']){
			$active = 'green';
		}
		printf('<div class="col   %s"> %s:00 </div>',$active,$hour);
		}
		?>

  	</div>
	<?php
	$w = getCalendarWeek($week);
	for ($i = 1; $i<=7; $i++) {	
		
		$active = 'bg-secondary';
		  
		//Check which day
		if(date_format(date_create(),'l jS') == date_format( $day,'l jS')) {
		    $active = 'green';
		}	
		
		//day wrapper
		echo('<div class ="col p-0 border-right  weekday overflow-hidden">'); 

		//print header
		printf('<div class=" p-2 border-bottom   %s weekdayheader"> %s </div>',$active,date_format( $day,'D jS') );

		// print calendar events
		printWeekday($w,$i);

		//close day wrapper
		printf('</div>');

		// Increment day
		$day = date_modify($day,"1 days");	
	}

  	#include('closeDB.php');
	include('experimentModal.php');
	?>

</div>

