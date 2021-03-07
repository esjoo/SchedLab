<head>
    <link rel="stylesheet" type="text/css" href="style/protocol.css">
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
        <form action="showProtocol.php" method='post' onsubmit="return checkip()">
        
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
                    <h5 class="margin">Chemical</h5> 
                    <input style="height:40px" type="text" autocomplete="off" placeholder="Search Chemicals" id="chem_name" /><button class="add-row button" id="add"><span>ADD</span></button><button class="delete-row button"><span>REMOVE</span></button>
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

<script>
(function(){
    var f1 = document.getElementById('name'),     
        b1 = document.getElementById('add'),
		t = document.getElementById('To_che');
    b1.onclick = function() {
        t.value = f1.value;        
    };
})();
</script>


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
