    <style>
        div {
            margin-top:25px;
	        margin-bottom:25px;
	        margin-right:25px;
	        margin-left:25px;
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
<body>
    <?php 
        include 'header.php';  
        include 'db.php';

        $sql = "SELECT Type FROM Protocols";
        $result = mysqli_query($conn, $sql);
        include 'closeDB.php';
    ?> 

<h1 class="margin">Create a new protocol</h1>
<div class="form" style="text-align: left;">
        <form action="showProtocol.php" method='post' name="protForm" onsubmit="return checkip()">
        
            <!-- Protocol name -->
            <div class="form-group">
                <h5 class="margin"><label for="name">Protocol name</label></h5>
                <input type="text" style="width:600px" class="form-control" placeholder="Enter name" name="protName" id="protName">
            </div>
                
            <!-- Equipment -->          
            <div id="equipmentArea" class="form-group">
                <h5 class="margin"><label for="equipment">Equipment</label></h5>
                <textarea name="equipment" id="equipment" style="width:600px;height:200px;" placeholder="Insert all equipments"></textarea>
            </div>
        

            <!-- Procedure -->
            <div class="form-group">
                <h5 class="margin"><label for="procedure">Procedure</label></h5>
                <textarea name="procedure" id="procedure" style="width:600px;height:200px;" placeholder="Insert procedure"></textarea>
            </div>


            <!-- chemicals--> 
            
            <div class="part">                
                <div class="search-box">
                    <input style="height:40px" type="text" autocomplete="off" placeholder="Search Chemicals" id="chem_name" /><button type="button" class="add-row button" id="add" onClick="nameCheck();"><span>ADD</span></button><button type="button" class="delete-row button"><span>REMOVE</span></button>
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

                    </tbody>
                </table>
            </div>

            <!-- Protocol Creater -->
            <div>
                <input type="hidden" name="ProtCreater" value="<?php echo $_SESSION['userName']?>">
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


<!-- live search box -->           
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
                         '<td><input type="text" placeholder="Enter Chemical" style="color:black" name="chemicals[]" id="To_che" class="chemicals" value="'+ name +'"/>' + '</td>'+
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


