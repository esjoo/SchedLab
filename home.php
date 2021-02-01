      <div class="d-flex flex-column vh-100 ">
          <div class="py-2 order-2">
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

          <div class="p-2 order-1">
            <h2>
                <?php 
                    echo 'Calendar for Week '. date('W')[1].' '. date('M');
                    ?> 
                </h2> 
            <?php  include('calendar.php');?>
          </div>
        </div>
    </div>

