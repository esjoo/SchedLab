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
            font-size: 15px;
            text-align: center;
            border-radius: 12px;
            height: 40px;
            transition: all 0.5s;
            cursor: pointer;
            margin: 5px;
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

<body style="background-color:#FBF3F3;">
    <?php 
        include 'header.php';  
        include 'db.php';

        $sql = "SELECT Type FROM Protocols";
        $result = mysqli_query($conn, $sql);
        include 'closeDB.php';
    ?> 

<h1 class="margin">Create a new protocol</h1>
<div class="form" style="text-align: left;">
        <form action="showProtocol.php" method='post'>
        
        <!-- Protocol name -->
        <div class="form-group">
            <h5 class="margin"><label for="name">Protocol name</label></h5>
            <input type="text" style="width:600px" class="form-control" placeholder="Enter name" id="name" name="name">
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
        <link rel="stylesheet" type="text/css" href="bootstrap-select.min.css">
        <script src="bootstrap-select.min.js"></script>  

            <div class="part">
            <h5>Choose the Chemical and input the Dosage</h5>
                <table id="main" width="50%">
                    <h6><th class="head">Chemical</th></h6>
                    <h6><th class="head">Dosage</th></h6>

                    <tr class="alt">
                        <td style="width:25%">
                            <div class="search-box">
                                <input type="text" autocomplete="off" placeholder="Search Chemicals" name="chemicals[]" />
                                <div class="result"></div>
                            </div>
                        </td>                                             
                        <td style="width:25%"><input type="number" placeholder="Enter Dosage" name="dosages[]"></td>
                    </tr>
                </table>

                <div id="display"></div>
                <input type="button" class="button" name="add" id="add" class="btn btn-success" value="Add" />                   
            </div> 
                  
        <!-- Chemicals which haven't been in the db -->  
        <div class="part">
            <h5>If you didn't find the chemicals that you need:</h5>                 
                <table id="NEWmain" width="50%">
                    <th class="head">Chemical</th>
                    <th class="head">Dosage</th>

                    <tr class="alt">
                        <td style="width:25%"><input type="text" placeholder="Enter Chemical" name="NEWchemicals[]"></td>
                        <td style="width:25%"><input type="number" placeholder="Enter Dosage" name="NEWdosages[]"></td>
                    </tr>
                </table>
                <input type="button" class="button" value="Add New Row" onclick="addRow();" id="rowButton" class="format" class="btn btn-primary" />            
        </div>

        <!-- Submit --> 
            <div class="form-group" style="text-align: center;">
                <button name="submit" type="submit" class="button" style="width: 200px"><span>Submit</span></button>
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