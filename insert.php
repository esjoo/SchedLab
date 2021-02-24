<!DOCTYPE html>

<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
        <!--   <link rel="stylesheet" type="text/css" href="bootstrap-select.min.css">
            <script src="bootstrap-select.min.js"></script>  -->

            <div>
                
                <div class="search-box">
                    <input type="text" autocomplete="off" placeholder="Search Chemicals" id="name" />
                    <div class="result"></div>
                </div>

                <input type="button" class="add-row" value="Add Row" id="add">

                <table>
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Chemical</th>
                            <th>Dosage</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
    
                <button type="button" class="delete-row">Delete Row</button>
            </div>

                <!--<table id="main">
                    <th class="head">Chemical</th>
                    <th class="head">Dosage</th>

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
                <input type="button" name="add" id="add" class="btn btn-success" value="Add" />                  
            </div> -->

  
                           
<!--            <input type="button" name="add" id="add" class="btn btn-success" value="Add" />
            <div ng-app="chemicals" ng-controller="myController">
                <label for="chemical">Chemicals & Dosages:</label>
                <ul>
                    <li>Chemical</li>
                        <li>
                            <input ng-model="name" type="text" id="search" placeholder="Enter Chemical" name="chemicals[]" />
                            <div id="display"></div> 
                        </li>
                </ul>

                <ul>
                    <li>Dosage</li>
                    <li><input type="number" ng-model="dosage" class="form-control" name="dosages[]" placeholder="dosage" /></li>
                </ul>

                <ul>
                    <li> </li><li><button ng-click="addRow()" type="button" class="btn btn-primary"> Add Row </button></li>
                </ul>
-->

<!--                <table id="cheANDdos"> 
                    <tr>
                    <th>Num</th>
                        <th>Chemicals</th>
                            <th>Dosage</th>
                    </tr>

                    <tr ng-repeat="chemicals in chemicalArray">
                        <td><label>{{$index + 1}}</label></td>
                        <td><label >{{chemicals.name}}</label></td>
                        <td><label >{{chemicals.dosage}}</label></td>
                        <td><input type="checkbox" ng-model="chemicals.Remove"/></td>
                    </tr>
                </table>

                <div>      
                    <button ng-click="removeRow()" type="button" class="btn btn-primary">Remove Row</button>
                </div>            
            </div> 
-->



        <!-- Chemicals which haven't been in the db -->  
        <!--<br>     
        If you haven't find the chimecals that you need:
            <div>
                <table id="NEWmain">
                    <th class="head">Chemicals</th>
                    <th class="head">Dosage</th>

                    <tr class="alt">
                        <td style="width:25%"><input type="text" placeholder="Enter Chemical" name="NEWchemicals[]"></td>
                        <td style="width:25%"><input type="number" placeholder="Enter Dosage" name="NEWdosages[]"></td>
                    </tr>
                </table>
                <input type="button" value="Add New Row" onclick="addRow();" id="rowButton" class="btn btn-primary" />        
            </div>
        <br>-->

        <!-- Submit --> 
            <div class="form-group" style="text-align: center;">
                <button name="submit" type="submit" class="button" style="width: 200px"><span>Submit</span></button>
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

</html>