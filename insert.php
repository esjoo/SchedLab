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
            
        }
        td, th {
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
        }
        h5.margin {
            margin-top:1px;
	        margin-bottom:1px;
        }
        h6.margin {
            margin-top:15px;
	        margin-bottom:15px;
            margin-right:25px;
	        margin-left:25px;
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
    </style>
</head>

    <?php 
        include 'header.php';  
        include 'db.php';

        $sql = "SELECT Type FROM Protocols";
        $result = mysqli_query($conn, $sql);
        include 'closeDB.php';
    ?> 


        <!-- Equipment -->
        <div class="form-group">
            <div id="equipmentArea" class="controls">
                <label for="equipment">Equipment:</label><br>
                <textarea name="equipment" cols="40" rows="5" placeholder="Insert all equipments"></textarea>
            </div>
        </div>


<h1 class="margin">Create a new protocol</h1>
<div class="form" style="text-align: left;">
        <form action="showProtocol.php" method='post'>
        
         <!-- Protocol name -->
         <div class="form-group">
            <h5 class="margin"><label for="name">Protocol name</label></h5>
            <input type="text" style="width:600px" class="form-control" placeholder="Enter name" name="name">
        </div>
            
        <!-- Equipment -->          
        <div id="equipmentArea" class="form-group">
            <h5 class="margin"><label for="equipment">Equipment</label></h5>
            <textarea name="equipment" style="width:600px;height:200px;" placeholder="Insert all equipments"></textarea>
        </div>
        

        <!-- Procedure -->
        <div class="form-group">
            <h5 class="margin"><label for="procedure">Procedure</label></h5>
            <textarea name="procedure" style="width:600px;height:200px;" placeholder="Insert procedure"></textarea>
        </div>



        <!-- chemicals which have been in the db --> 
            
            <div class="part">                
                <div class="search-box">
                    <input style="height:40px" type="text" autocomplete="off" placeholder="Search Chemicals" id="name" /><button type="button" class="add-row button" id="add"><span>ADD</span></button><button type="button" class="delete-row button"><span>REMOVE</span></button>
                    <div class="result"></div>
                </div>
                <table style="width:60%">
                    <thead>
                        <tr>
                            <h6><th>Select</th></h6>
                            <th>Chemical</th>
                            <th>Dosage</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        <!-- Submit --> 
            <div class="form-group" style="text-align: center;">
                <button name="submit" type="submit" class="button" style="width: 200px"><span>Show protocol</span></button>
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
            var name = $("#name").val();
            var markup = '<tr> '+
                         '<td><input type="checkbox" name="record"></td>' +
                         '<td><input type="text" placeholder="Enter Chemical" name="chemicals[]" id="To_che" value="'+ name +'"/>' + '</td>'+
                         '<td><input type="number" placeholder="Enter Dosage" name="dosages[]"></td></tr>';
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


