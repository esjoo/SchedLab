<!DOCTYPE html>
<html>

<?php 
include 'header.php';  
include 'db.php';

$sql = "SELECT Type FROM Protocol";
$result = mysqli_query($conn, $sql);
include 'closeDB.php';
?> 

<h1>Create a new protocol</h1>
<div class="form">
    <form action="insert.inc.php" method='post'>
        <!-- Protocol name -->
        <div class="form-group">
            <label for="name">Protocol name:</label>
            <input type="text" class="form-control" placeholder="Enter name" id="name" name="name">
        </div>
                
        

        <!-- Equipment -->
        <div class="form-group">
            <div id="equipmentArea" class="controls">
                <label for="equipment">Equipment:</label><br>
                <textarea name="equipment" cols="40" rows="5" placeholder="Insert all equipments"></textarea>
            </div>
        </div>

                
        <!-- Chemicals -->
        
        <link rel="stylesheet" type="text/css" href="bootstrap-select.min.css">
        <script src="bootstrap-select.min.js"></script>

        <div class="form-group" id="chemicals">
        <label for="chemical">Chemicals:</label><br>
            <select class="selectpicker" placeholder="Chemical" name="chemical" data-live-search="true">
            <?php 
            include 'db.php';               
            $result = mysqli_query($conn,"SELECT * FROM Supplement");
            while($row = $result->fetch_assoc()){
                $catID = $row['SupID'];
                $catName = $row['SupName'];
                echo "<option value='$catID'>$catName</option>";
                echo '<br>';
            }
            include 'closeDB.php';
            ?>
        
            </select>
        </div>

        <!-- Procedure -->
        <div class="form-group">
            <label for="procedure">Procedure:</label><br>
            <textarea name="procedure" cols="40" rows="5" placeholder="Insert procedure"></textarea>
        </div>

        <!-- Submit --> 
        <div class="form-group">
            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
  </section>

  <?php 
 
  include('footer.php');  
  ?> 

  </html>
