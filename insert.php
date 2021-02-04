<?php 
include('header.php');  
 require_once('db.php');

$sql = "SELECT Type FROM protocol";
$result = mysqli_query($conn, $sql);
?> 
        
<div class="form">
    <form action="insert.inc.php" method='post'>
        <!-- Protocol name -->
        <div class="form-group">
            <label for="name">Protocol name:</label>
            <input type="text" class="form-control" placeholder="Enter name" id="name" name="name">
        </div>

        <!-- Protocol type -->
        <div class="form-group">
            <label for="type">Protocol type:</label>
            <select class="form-control" id="type" name= "type">
            <?php 
                while($row = mysqli_fetch_row($result)){ 
                    echo ("<option>". $row[0] . "</option>");     
                }
            ?>
            </select>
        </div>
                
        <!-- Procedure -->
        <div class="form-group">
            <label for="procedure">Procedure:</label><br>
            <textarea name="procedure" cols="40" rows="5" placeholder="Insert procedure"></textarea>
        </div>

        <!-- Equipment -->
        <div class="form-group">
            <div id="equipmentArea" class="controls">
                <label for="equipment">Equipment:</label><br>
                <textarea name="equipment" cols="40" rows="5" placeholder="Insert all equipments"></textarea>
            </div>
        </div>

        <!-- Chemicals -->
        <div class="form-group" id="chemicals">
            <label for="chemical">Chemicals:</label><br>
            <input type="text" style="width:85%;float:left;margin-bottom:5px;" class="form-control" id="chemical1" name="chemical" placeholder="Chemical" value=""><br><br>
            <input type="button" class="btn btn-success btn-sm" name="plus" id="plus" value="+" onclick="addMore(1);"><br> <!--style="font-size:21px; line-height:12px; border-radius:4px; margin:3px; margin-bottom:6px;"  style="width:85%;float:left; margin-bottom:5px;"-->
        </div>

        <script>
        function addMore(i) {

            $("#plus").remove();

            $('#chemicals').append('<div><input type="text" style="width:85%;float:left;margin-bottom:5px;" class="form-control" id="chemical' + i + '" name="chemical" placeholder="Chemical" value="">'+
            '<input type="button" onclick="removeThis(' + i + ');" class="btn btn-danger btn-sm" name="minus" id="minus' + i + '" value="-"></div>' +
            '<div> <input type="button" class="btn btn-success btn-sm" name="plus" id="plus" value="+" onclick="addMore(' + (i++) + ');"><br></div>');
        }

        function removeThis(j) {
            $("#chemical" + j).remove();
            $("#minus" + j).remove();
        }
        </script>

        <!-- Submit -->
        <div class="form-group">
            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    </div>
  </section>

  <?php 
  include('closeDB.php');
  include('footer.php');  
  ?> 
