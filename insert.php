<!DOCTYPE html>

<!-- 
    This version covers almost all basic function used when created a new protocol, but there is
    also a problem, which is when add the chemicals have been in the SUPPLEMENT database, only the 
    first row can be live search box, the rest must be input the full name. I would solve this when 
    we finish other core function.
-->

<html>
<head>
    
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <style>
        div {

        }
        a:hover {
            cursor: pointer;
            background-color: yellow;
        }
        
        ul {
            padding:0;
            margin:2px 5px; 
            list-style:none; 
            border:0; 
            float:left; 
            width:100%;
        }
        li {
            width:40%; 
            float:left; 
            display:inline-block; 
        }
        table, input {
            text-align:left;
        }
        table, td, th 
        {
            margin:80px 0;
            padding:4px 20px;
        }
        td, th {
            border:solid 1px #CCC;
        }
        button {
            padding:3px 5px;
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


    <h1>Create a new protocol</h1>
    <div class="form">
        <form action="showProtocol.php" method='post'>
        
        <!-- Protocol name -->
            <div class="form-group form-inline" style="padding-left:10px">
                <label for="name">Protocol name:</label></br>
                <input type="text" class="form-control" placeholder="Enter name" id="name" name="name">
            </div>
                
        <!-- Equipment -->          
            <div id="equipmentArea" class="controls form-group form-inline">
                <label for="equipment">Equipment:</label><br>
                <textarea name="equipment" cols="40" rows="5" placeholder="Insert all equipments"></textarea>
            </div>
            
        <!-- Procedure -->
            <div class="form-group form-inline">
                <label for="procedure">Procedure:</label><br>
                <textarea name="procedure" cols="40" rows="5" placeholder="Insert procedure"></textarea>
            </div>


        <!-- chemicals which have been in the db --> 
           <link rel="stylesheet" type="text/css" href="bootstrap-select.min.css">
            <script src="bootstrap-select.min.js"></script>  

            <div>
                <table id="main">
                    <th class="head">Chemical</th>
                    <th class="head">Dosage</th>

                    <tr class="alt">
                        
                        <td>
                            <div class="search-box">
                                <input type="text" autocomplete="off" placeholder="Search Chemicals" name="chemicals[]" />
                                <div class="result"></div>
                            </div>
                        </td>                                             
                        <td><input type="number" placeholder="Enter Dosage" name="dosages[]"></td>
                    </tr>
                </table>

                <div id="display"></div>
                <input type="button" name="add" id="add" class="btn btn-success" value="Add" />                  
            </div> 
                  
        <!-- Chemicals which haven't been in the db -->  
        <br>     
        If you haven't find the chimecals that you need:
            <div>
                <table id="NEWmain">
                    <th class="head">Chemicals</th>
                    <th class="head">Dosage</th>

                    <tr class="alt">
                        <td><input type="text" placeholder="Enter Chemical" name="NEWchemicals[]"></td>
                        <td><input type="number" placeholder="Enter Dosage" name="NEWdosages[]"></td>
                    </tr>
                </table>
                <input type="button" value="Add New Row" onclick="addRow();" id="rowButton" class="btn btn-primary" />        
            </div>
        <br>

        <!-- Submit --> 
            <div class="form-group">
                <button name="submit" type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</body>


                        

<!-- New chemicals-->
<script>
    function addRow() {
    var table = document.getElementById("NEWmain");
	var rws = table.rows;
	var cols = table.rows[0].cells.length;
    var row = table.insertRow(rws.length);
	var cell1;
	var cell2;
	cell1 = row.insertCell(0);
	cell1.innerHTML = '<input type="text" placeholder="Enter Chemical" name="NEWchemicals[]">';

	cell2 = row.insertCell(1);
	cell2.innerHTML = '<input type="number" placeholder="Enter Dosage" name="NEWdosages[]">';
    }
</script>



<script type="text/javascript">

$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("ajaxFORinsert.php", {term: inputVal}).done(function(data){
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

    $('#add').click(function(){
        var html = '<tr>';
        html += '<td>';
        html += '<div class="search-box">';
        html += '<input type="text" autocomplete="off" placeholder="Search Chemicals" name="chemicals[]" />';
        html += '<div class="result"></div>';
        html += '</div>';
        html += '</td>';
        html += '<td><input type="number" placeholder="Enter Dosage" name="dosages[]"></td>';
        html += '</tr>';
        $('#main tbody').append(html);
    });

});
</script>

</html>