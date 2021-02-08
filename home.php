      <div class="d-flex flex-row vh-100 ">
          <div class="py-2">
          <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#leftCol">Stats</button>
            <div class="collapse" id="leftCol">
            <h3>Some Links</h3>
            <p>Lorem ipsum dolor sit ame.</p>
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
            <hr class="d-sm-none">
          </div>

          <div class="p-2">
            <h2>
                <?php 
                  if(!isset($_GET['w'])) {
                    #set first day
                    $today = date_create();
                   
                    $day = date_isodate_set($today, date_format($today,'o'), date_format($today,'W') , 1 ); #TODO: change year
                    $week = date_format($day,'W');
                    echo 'Calendar for '. date_format($day,'M') .' Week '. $week;
                    

                  } else {
                    $day = date_isodate_set(date_create(), date_format(date_create(),'o'), $_GET['w'] , 1 ); #TODO: change year
                    $week = $_GET['w'];
                    
                    #set monday of specified week
                    echo 'Calendar for Week '. date_format($day,'W').' '. date_format($day,'M');
                  }
                  ?> 
              </h2> 
                
              <a class="" href= <?php echo('?w='. $week-1); ?>><img src="gfx/left_cal.png"></a>

              <a class="" href=<?php echo('?w='. $week+1); ?>><img src="gfx/right_cal.png"></a>

            <?php  include('calendar.php');?>
          </div>
        </div>
    </div>

