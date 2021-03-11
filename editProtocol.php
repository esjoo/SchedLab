<head>
    <link rel="stylesheet" type="text/css" href="style/protocol.css">
</head>

    <?php 
        include 'header.php';  
        $name = $_POST['protName'];
        $procedure = $_POST['procedure'];
        $equipment = $_POST['equipment'];
        $chemicals = $_POST['chemicals'];
        $dosages = $_POST['dosages'];
        $ProtCreater = $_POST['ProtCreater'];

    ?> 

        <h1>Create a new protocol</h1>
        <div class="color">
            <form action="showProtocol.php" method='post'>
            
                <!-- Protocol name -->
                <div>
                    <h5><label for="name">Protocol name</label></h5>
                    <input type="text" style="width:600px;margin:auto" class="form-control" placeholder="Enter name" name="protName" value="<?php echo $name?>">
                </div>
                    
                <!-- Equipment -->          
                <div id="equipmentArea">
                    <h5><label for="equipment">Equipment</label></h5>
                    <?php
                        $e = strip_tags($equipment, true);
                        echo '<textarea name="equipment" style="width:600px;height:200px;" placeholder="Insert all equipments" >' . $e . '</textarea>';
                    ?>
                    
                </div>
            

                <!-- Procedure -->
                <div class="form-group">
                    <h5><label for="procedure">Procedure</label></h5>
                    <?php
                        $p = strip_tags($procedure, true);
                        echo '<textarea name="procedure" style="width:600px;height:200px;" placeholder="Insert procedure" >' . $p . '</textarea>';
                    ?>
                    
                </div>


                <!-- chemicals --> 
                
                <div>                
                    <div class="search-box">
                        <input style="height:40px" type="text" autocomplete="off" placeholder="Search Chemicals" id="chem_name" /><button type="button" class="add-row button" id="add"><span>ADD</span></button><button type="button" class="delete-row button"><span>REMOVE</span></button>
                        <div class="result"></div>
                    </div>
                    <table style="width:60%">
                        <thead>
                            <tr>
                                <th><h6 class="font" style="text-align: center;">Select</h6></th>
                                <th><h6 class="font" style="text-align: center;">Chemical</h6></th>
                                <th><h6 class="font" style="text-align: center;">Dosage</h6></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $len = count($chemicals);
                                for($i=0;$i<$len;$i++){
                                    echo '<tr>';
                                    echo '<td><input type="checkbox" name="record"></td>';
                                    echo '<td><input type="text" placeholder="Enter Chemical" style="color:black" name="chemicals[]" id="To_che" value="' . $chemicals[$i] . '"/></td>';
                                    echo '<td style="color:black"><input type="number" step="0.0001" oninput="validity.valid||(value=``);" onpress="isNumber(event)" placeholder="Enter Dosage" name="dosages[]" value="' . $dosages[$i] . '"></td>';                                   
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Protocol Creater -->
                <div>
                    <input type="hidden" name="ProtCreater" value="<?php echo $ProtCreater?>">
                </div>

                <!-- Submit --> 
                <div>
                    <div class="form-group" style="text-align: center;">
                        <button name="submit" type="submit" class="button" style="width:200px"><span>Show protocol</span></button>
                    </div>
                </div>
            </form>
        </div>
        <h2 style="opacity:0">Blank Space</h2>
</body>


               
<script type="text/javascript">

$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("livesearchFORprotocol.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });

});
</script>

<!-- add the row of chemicals and dosages + check if there is same chemical name -->
<script>
    $(document).ready(function(){
        $(".add-row").click(function(){
            var name = $("#chem_name").val();
            var markup = '<tr> '+
                         '<td><input type="checkbox" name="record"></td>' +
                         '<td><input type="text" placeholder="Enter Chemical" style="color:black" name="chemicals[]" id="To_che" value="'+ name +'"/>' + '</td>'+
                         '<td style="color:black"><input type="number" step="0.0001" oninput="validity.valid||(value=``);" onpress="isNumber(event)" placeholder="Enter Dosage" name="dosages[]"></td></tr>';
                         var objs  = document.getElementsByName("chemicals[]");
            var my_chem = new Array();
            for(var i = 0; i < objs.length; i++){
                my_chem.push(objs[i].value);
            };
            
            if(objs.length == 0){
                $("table tbody").prepend(markup);
            }else{
                               
                if(my_chem.indexOf(name)>-1){
                    alert("There are reduplicate chemical names!");
                    return false;
                }else{
                    $("table tbody").prepend(markup);
                };
                return true;            
            }
        });
        
        // Find and remove selected table rows
        $(".delete-row").click(function(){
            $("table tbody").find('input[name="record"]').each(function(){
                if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                }
            });
        });
    });    
</script>

<!-- check if there are empty value -->
<script language="javascript">
 function checkip() {
        var protName = $('#protName').val()
        var procedure = $('#procedure').val()
        var equipment = $('#equipment').val()
        var chemical = $('#chem_name').val()
        if (protName==""){
            alert('Protocal name cannot be empty')
            return false;
        }else if(procedure==""){
            alert('Procedure cannot be empty')
            return false;
        }else if(equipment==""){
            alert('Equipment cannot be empty')
            return false;
        }else if(chemical.length==0){
            alert('Chemicals cannot be empty')
            return false;
        }else{
            return true;   
        }
    }
</script>

<!-- dosage value control -->
<script language="javascript">
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    let charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
      evt.preventDefault();
    } else {
      return true;
    }
  }
</script>