<?php include('header.php');  
 require_once('db.php');

$sql = "SELECT Type FROM protocol";
$result = mysqli_query($conn, $sql);
?> 

<h1>Create a new protocol</h1>
<div class="form">
    <form action="insert.inc.php" method='post'>
        <!-- Protocol name -->
        <div class="form-group">
            <label for="name">Protocol name:</label>
            <input type="text" class="form-control" placeholder="Enter name" id="name" name="name">
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
            <select name="chemical" style="width:85%;float:left;margin-bottom:5px;"class="form-control" name="chemical0" placeholder="Chemical" value=""> 
                <?php 
                $result = mysqli_query($conn,"SELECT ChemID, ChemName FROM chemicals ORDER BY ChemName"); 
                $options = array();
                while($row = mysqli_fetch_assoc($result)) { 
                    $catid = $row["ChemID"];
                    $catname = $row["ChemName"]; //here we display genre name in drop down list and pass catid value when posting back to (add_book.php)
                    array_push($options, $catid => $catname);
                    print "<option value='$catid'>$catname</option>"; 
                }
                
                ?> 
            </select>
            <!--<input type="text" style="width:85%;float:left;margin-bottom:5px;" class="form-control" name="chemical0" placeholder="Chemical" value="">-->
            <input type="button" class="btn btn-success" name="plus" id="plus" value="+" onclick="addMore(1, $options);">
        </div>

        <script>
        function addMore(i, opt) {

            $("#plus").remove();

            var x = opt.entries();
            for (a of x){
                option += '<option value='+$catid'>$catname</option>
            }

            $('#chemicals').append('<div><input type="button" onclick="removeThis(' + i + ');" class="btn btn-danger" name="minus" id="minus' + i + '" value="-"></div>' 
            + '<div><select name="chemical" style="width:85%;float:left;margin-bottom:5px;"class="form-control" name="chemical0" placeholder="Chemical" value="">' 
            + '<option value= + '</select>'
            + '<input type="button" class="btn btn-success" name="plus" id="plus" value="+" onclick="addMore(' + (++i) + ');"></div>');
        
            /*$('#chemicals').append('<div><input type="button" onclick="removeThis(' + i + ');" class="btn btn-danger" name="minus" id="minus' + i + '" value="-"></div>' 
            + '<div><input type="text" style="width:85%;float:left;margin-bottom:5px;" class="form-control" name="chemical' + i + '" placeholder="Chemical" value="">'
            + '<input type="button" class="btn btn-success" name="plus" id="plus" value="+" onclick="addMore(' + (++i) + ');"></div>');*/
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
  include('footer.php');  ?> 
