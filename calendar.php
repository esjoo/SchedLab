<link rel="stylesheet" href="style/calendar.css">


<!-- calendar window-->
<div class="box" id="calendar">
  <!-- column Time wrapper -->
  <div class= "d-flex flex-column border-right">
    <!-- header-->
    <div class="p-2 border-bottom bg-secondary"> Time </div>
    <!-- content -->
    <?php 
    foreach (range(8,17) as $hour) {
      $active='';
      if($hour == localtime(time(),TRUE)['tm_hour']){
        $active = 'green';
      }
      printf('<div class="col  %s"> %s:00 </div>',$active,$hour);
    }
    ?>

  </div>
	<?php
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

		// Get calender events
		include('db.php');
    	$userID = get_current_user_id();
		$sql = "SELECT * FROM usercalendar WHERE UserID = $userID AND WEEK(FromDateTime)=".intval(date_format($today,'W')) ." ORDER BY FromDateTime";
		$result = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_row($result)) {
			$sameDay = FALSE;
			if (isset($date)){
				$prevDateTime = $date;
				$prevDate = $date->format('Y-m-d');
				$prevEventEnd = $dateEnd->format('G:i:s');
			}

			$date = DateTime::createFromFormat('Y-m-d G:i:s', $row[1]);
			$dateEnd = DateTime::createFromFormat('Y-m-d G:i:s', $row[2]);
			$thisDate = $date->format('Y-m-d');
	
			// Check if there is another event before this the same day
			if (isset($prevDate) && $thisDate == $prevDate) {
				$sameDay = TRUE;
			}

			// Get event information 
			if(date_format($date,'l jS') == date_format( $day,'l jS')) {
				$protocolContent = "Time and date for the experiment: ".$row[1]."-".$row[2];

				// Get the date and time of an experiment
				$trgButton = dateTimeToElement($row[1], $row[2])/11*100 . '%';
				$eventStart = $date->format('G:i:s');

				// Add correct spacing befor the event
				if ($sameDay){
					$eventMargin = dateTimeToElement($prevEventEnd, $eventStart)/11*100 . '%';
				} else {
					$eventMargin = dateTimeToElement('08:00:00', $eventStart)/11*100 . '%';
				}

				// Get header of an experiment
				$calenID = $row[0];
				$protID = (int)$row[4];
				$prot_sql = "SELECT ProtID, ProtName FROM protocols WHERE ProtID=$protID";
				$protName = mysqli_query($conn, $prot_sql);
				$protocolName = mysqli_fetch_row($protName);
				$protocolHeader = $protocolName[1];

				// print content
				printf('<div class="border border-0" style="height:%s"></div>
				',$eventMargin);
				printf('
				<div class="btn col mr-1 border p-0 day btn-calendar" data-toggle="modal" data-target="#exampleModal" data-calenID="%s" data-protocolHead="%s" data-protocolContent="%s" style="height:%s">%s</div>
		    		',$calenID,$protocolHeader,$protocolContent,$trgButton,$protocolHeader);
			}
		}

		//close day wrapper
		printf('</div>');

		// Increment day
		$day = date_modify($day,"1 days");	
	}

  include('closeDB.php');
	include('experimentModal.php');
	?>

</div>

