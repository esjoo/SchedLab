<div class="container-fluid w-100 h-100">
  <div class="d-flex h-75">
  <!--SIDEBAR -->
    <div class="py-2">
      <div class="collapse" id="leftCol">
        <div class="p-2">
          <?php 
            include('sidebarCalendar.php');
              
              ?>
        </div>
        <h3><?php echo get_current_user_labName(); ?></h3>
        <p>This week at a glimpse.</p>
        <ul class="nav nav-pills flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="#">This week costs: {}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">List of materials consumed</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Time allocated</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Disabled</a>
          </li>
        </ul>
      </div>
    </div>
    <!--Main -->
    <div class="col">
        <!-- calendar top -->
        <div class=" row">
          <!--Top text -->
          <h2 class="h-100">
            <?php 
                    if(!isset($_GET['w'])) {
                      #set first day
                      $today = date_create();
                      
                      $day = date_isodate_set($today, date_format($today,'o'), date_format($today,'W') , 1 ); #TODO: change year
                      
                      #set week endpoint
                      $monday = $day;
                      $sunday = date_isodate_set(date_create(), date_format($today,'o'), date_format($today,'W') , 7 );
                      
                      
                      #print week
                      $week = date_format($day,'W');
                      echo 'Calendar for '. date_format($day,'M') .' Week '. $week;
                      

                    } else {
                      #set monday of specified week
                      $day = date_isodate_set(date_create(), date_format(date_create(),'o'), $_GET['w'] , 1 ); #TODO: change year
                     
                      #set week endpoint
                      $monday = $day;
                      $sunday = date_isodate_set(date_create(), date_format($day,'o'), date_format($day,'W') , 7 );
                      
                      #print week
                      $week = $_GET['w'];
                      echo 'Calendar for Week '. date_format($day,'W').' '. date_format($day,'M');
                    }
                    ?>
          </h2> 

          <a class="" href=<?php echo('?w='. ((int)$week-1)); ?>><img src="gfx/left_cal.png"></a>
          <a class="" href=<?php echo('?w='. ((int)$week+1)); ?>><img src="gfx/right_cal.png"></a>
          <a class="ml-auto p-2" data-toggle='modal' href='#newExperiment'><img src="gfx/plus.png"></a>
          
        </div>
        <?php    
          #if(!isset($_SESSION['lab'])){
            include('newExperiment.php'); 
            include('calendar.php');
            #} else {
              #include(''); //OOPS something went wrong
            #}
            ?>
            
      </div>
  </div>
</div>
</div>
