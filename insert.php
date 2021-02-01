<?php include('header.php');  
 require_once('db.php');


    
$sql = "SELECT name FROM genres";

$result = mysqli_query($conn, $sql);


?> 



        <div class="form">
            <form action="insert.inc.php" method='post'>
                <div class="form-group">
                    <label for="email">Title:</label>
                    <input type="text" class="form-control" placeholder="Enter title" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="genre">Genre:</label>
                    <select class="form-control" id="genre" name= "genre">
                    <?php 
                    while($row = mysqli_fetch_row($result)){
                        
                        echo ("<option>". $row[0] . "</option>"); 
                        
                    }
                     ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="year">year:</label>
                    <input type="text" class="form-control" placeholder="Enter year" id="year" name="year">
                </div>


                <div class="form-group">
                    <label for="rating">Select rating:</label>
                    <select class="form-control" id="rating" name= "rating">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
  </section>
  <?php 
  include('closeDB.php');
  include('footer.php');  ?> 
