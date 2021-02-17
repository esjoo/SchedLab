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


        <!-- Procedure -->
        <div class="form-group">
            <label for="procedure">Procedure:</label><br>
            <textarea name="procedure" cols="40" rows="5" placeholder="Insert procedure"></textarea>
        </div>

                
        <!-- Chemicals -->
        
        <link rel="stylesheet" type="text/css" href="bootstrap-select.min.css">
        <script src="bootstrap-select.min.js"></script>

        
        <label for="chemical">Chemicals & Dosages:</label>
        <br>        
        <div class="form-group form-inline" id="chemicals">           
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
                <input type="number" class="form-control" name="dosage" placeholder="dosage" />
                
        </div>
        <button class="btn btn-primary" id="addLine">ADD</button>

        <script type="text/javascript">
		/* 新增检测时间 */
		$("#addLine").click(function() {
		
			var htm = "";
			htm += "<div class='form-group form-inline' id='chemicals'>";
			htm += "<select class='selectpicker' placeholder='Chemical' name='chemical' data-live-search='true'>";
			htm += "";
			htm += "</select>";
			htm += "<input type='number' class='form-control' name='dosage' placeholder='dosage' />";			
			htm += "</div>";

			$('#chemicals').append(htm);			
		});	
	    </script>
        <br>

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
