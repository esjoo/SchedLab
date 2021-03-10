<head>
    <link rel="stylesheet" type="text/css" href="style/main.css"> 
    <div id="particles-js"></div>
    <script type="text/javascript" src="scripts/particles.js"></script>
    <script type="text/javascript" src="scripts/app.js"></script>
</head>

<div id="main" style="margin-top:-600px">
    <div class="box" style="z-index:100">
    <!--SIDEBAR -->
        <div class="box-child">
            <div class="collapse" id="leftCol">
              <div class="p-2">
                <?php 
                  include('sidebarCalendar.php');
                ?>
              </div>
              <div class="part" style="z-index:100">
                <h5 id="demofont1"><?php echo get_current_user_labName(); ?></h5>
                <h8 id="demofont2" style="margin:right">This week at a glimpse.</h8>
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <a class="nav-link" id="hypertext" href="#">This week's cost</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="hypertext" href="#">List of chemicals consumed</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="hypertext" href="#">Time allocated</a>
                  </li>
                </ul>
              </div>
            </div>
        </div>
        <!--Main -->
        <div class="col">
            <!-- calendar top -->
            <div class="row">
              <!--Top text -->
              <h2 style="margin:25 50 50 0px">
                <?php 
                        if(!isset($_GET['w'])) {
                          #set first day
                          $today = date_create();
                          
                          $day = date_isodate_set($today, date_format($today,'o'), date_format($today,'W') , 1 ); #TODO: change year
                          
                          #set week endpoint
                          $monday = $day;
                          #$sunday = date_isodate_set(date_create(), date_format($today,'o'), date_format($today,'W') , 7 );
                          
                          
                          #print week
                          $week = date_format($day,'W');
                          echo '<h id="demofont3"> Calendar for '. date_format($day,'M') .' Week </h>'. $week;
                          

                        } else {
                          $today = date_create();
                          #set monday of specified week
                          $day = date_isodate_set(date_create(), date_format(date_create(),'o'), $_GET['w'] , 1 ); #TODO: change year
                        
                          #set week endpoint
                          $monday = $day;
                          #$sunday = date_isodate_set(date_create(), date_format($day,'o'), date_format($day,'W') , 7 );
                          
                          #print week
                          $week = $_GET['w'];
                          echo '<h id="demofont3"> Calendar for Week '. date_format($day,'W').' '. date_format($day,'M') . '</h>';
                        }
                        ?>
              </h2>
            </div>
              <a id="link1" href=<?php echo('?w='. ((int)$week-1)); ?>><img id='imglink' src="gfx/left_cal.png"></a>
              <a id="link2" href=<?php echo('?w='. ((int)$week+1)); ?>><img id='imglink' src="gfx/right_cal.png"></a>
              <a id="link2" data-toggle='modal' href='#newExperiment'><img id='imglink' src="gfx/plus.png"></a>
            
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
