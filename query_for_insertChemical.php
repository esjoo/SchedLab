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