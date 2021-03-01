<style>
        div {
            margin-top:25px;
	        margin-bottom:25px;
	        margin-right:25px;
	        margin-left:25px;
            color:black;
        }
        div.part {
            border-radius: 5px;
            background-color: #f5e0e0;
            padding: 20px;
        }
        a:hover {
            cursor: pointer;
            background-color: yellow;
        }
        table, input {
            margin-top:15px;
	        margin-bottom:15px;
            text-align:left;
        }
        table, td, th 
        {
            margin:25px;
            padding:4px 20px;
            border:2px solid #e2a6a6;
            background-color: #FBF3F3;
        }
        input[type=text] {
            border: 2px solid #e2a6a6;
        }
        input[type=number] {
            border: 2px solid #e2a6a6;
        }
        textarea{
            border: 2px solid #e2a6a6;
        }
        select{
            border: 2px solid #e2a6a6;
        }
        h1.margin {
            margin-top:25px;
	        margin-bottom:25px;
	        margin-right:50px;
	        margin-left:50px;
            color:black;
        }
        h5.margin {
            margin-top:1px;
	        margin-bottom:1px;
            color:black;
        }
        h6.font {
            margin:0px;
            color:black;
        }
        .button {
            background-color:#79ab79;
            border: none;
            color:white;
            font-size: 20px;
            text-align: center;
            border-radius: 12px;
            height: 40px;
            transition: all 0.5s;
            cursor: pointer;
        }
        .button span {
            cursor: pointer;
            display: inline-block;
            position: relative;
            transition: 0.5s;
        }
        .button span:after {
            content: '\00bb';
            position: absolute;
            opacity: 0;
            top: 0;
            right: -20px;
            transition: 0.5s;
        }
        .button:hover span {
            padding-right: 25px;
        }
        .button:hover span:after {
            opacity: 1;
            right: 0;
        }
        p{
            color:black;
        }
    </style>
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

<h1 class="margin">Create a new protocol</h1>
<div class="form" style="text-align: left;">
        <form action="showProtocol.php" method='post'>
        
            <!-- Protocol name -->
            <div class="form-group">
                <h5 class="margin"><label for="name">Protocol name</label></h5>
                <input type="text" style="width:600px" class="form-control" placeholder="Enter name" name="protName" value="<?php echo $name?>">
            </div>
                
            <!-- Equipment -->          
            <div id="equipmentArea" class="form-group">
                <h5 class="margin"><label for="equipment">Equipment</label></h5>
                <?php
                    $e = strip_tags($equipment, true);
                    echo '<textarea name="equipment" style="width:600px;height:200px;" placeholder="Insert all equipments" >' . $e . '</textarea>';
                ?>
                
            </div>
        

            <!-- Procedure -->
            <div class="form-group">
                <h5 class="margin"><label for="procedure">Procedure</label></h5>
                <?php
                    $p = strip_tags($procedure, true);
                    echo '<textarea name="procedure" style="width:600px;height:200px;" placeholder="Insert procedure" >' . $p . '</textarea>';
                ?>
                
            </div>


            <!-- chemicals which have been in the db --> 
            
            <div class="part">                
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
                                echo '<td style="color:black"><input type="number" placeholder="Enter Dosage" name="dosages[]" value="' . $dosages[$i] . '"></td>';
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

<script>
    $(document).ready(function(){
        $(".add-row").click(function(){
            var name = $("#chem_name").val();
            var markup = '<tr> '+
                         '<td><input type="checkbox" name="record"></td>' +
                         '<td><input type="text" placeholder="Enter Chemical" style="color:black" name="chemicals[]" id="To_che" value="'+ name +'"/>' + '</td>'+
                         '<td style="color:black"><input type="number" placeholder="Enter Dosage" name="dosages[]"></td></tr>';
            $("table tbody").prepend(markup);
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


