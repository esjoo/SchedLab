<!DOCTYPE html>

<html>
<head>
    
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js"></script>
    
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
        ul {
            padding:0;
            margin:2px 25px; 
            list-style:none; 
            border:0; 
            float:left; 
            width:100%;
        }
        li {
            width:15%; 
            float:left; 
            display:inline-block; 
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
        button.format {
            background-color:#79ab79;
            border: none;
            color:white;
            font-size: 20px;
            text-align: center;
            border-radius: 12px;
            height: 40px;
            transition: all 0.5s;
            cursor: pointer;
            margin: 5px;
        }
        button.format span {
            cursor: pointer;
            display: inline-block;
            position: relative;
            transition: 0.5s;
        }

        button.format span:after {
            content: '\00bb';
            position: absolute;
            opacity: 0;
            top: 0;
            right: -20px;
            transition: 0.5s;
        }

        button.format:hover span {
            padding-right: 25px;
        }

        button.format:hover span:after {
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
    <form action="insert.inc.php" method='post'>

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

        <div ng-app="chemicals" ng-controller="myController" class="part">
            <h5 class="margin"><label for="chemical">Chemicals & Dosages</label></h5>
            <ul>
                <h6>Choose the Chemical and input the Dosage</h6>
                    <li>
                        <select style="width:150px;height:30px" ng-model="name" class="selectpicker" placeholder="Chemical" name="chemical" data-live-search="true">
                            <?php 
                                include 'db.php';               
                                $result = mysqli_query($conn,"SELECT * FROM Supplement");
                                while($row = $result->fetch_assoc()){
                                    $catID = $row['SupID'];
                                    $catName = $row['SupName'];
                                    echo "<option value='$catName'>$catName</option>";
                                    echo '<br>';
                                }
                                include 'closeDB.php';
                            ?>       
                        </select>
                    </li>
                    <li>
                        <input type="number" ng-model="dosage"  style="width:150px;height:30px" class="form-control" name="dosage" placeholder="Dosage" />
                    </li>
            </ul>

            <ul>
                <li> </li><li><button ng-click="addRow()" class="format" type="button" style="width: 50px"><span>+</span></button></li>      
                <li><button ng-click="removeRow()" class="format" type="button" style="width: 50px"><span>-</span></button></li>
            </ul>

        <!--CREATE A TABLE-->
            <table width="50%"> 
                <tr>
                <th>Num</th>
                    <th>Chemicals</th>
                        <th>Dosage</th>
                </tr>

                <tr ng-repeat="chemicals in chemicalArray">
                    <td style="width:30%"><label>{{$index + 1}}</label></td>
                    <td style="width:30%"><label>{{chemicals.name}}</label></td>
                    <td style="width:30%"><label>{{chemicals.dosage}}</label></td>
                    <td><input type="checkbox" ng-model="chemicals.Remove"/></td>
                </tr>
            </table>            
        </div>


        <div class="part">
            <!-- Chemicals which haven't been in the db -->     
            <h6 class="margin">If you didn't find the chemicals that you need:</h6>
            <ul>
                <li>
                    <button onclick="addRow();" class="format" id="rowButton" style="width: 50px"><span>+</span></button>
                </li>
            </ul>
            <table width="50%" id="main">
                <th class="head">Chemicals</th>
                <th class="head">Dosages</th>

                <tr class="alt">
                    <td style="width:25%"><input type="text" placeholder="Enter Value"></td>
                    <td style="width:25%"><input type="number" placeholder="Enter Value"></td>
                </tr>
            </table>
            
        </div>        


        <!-- Submit --> 
        <div class="form-group" style="text-align: center;">
            <button name="submit" type="submit" class="format" style="width: 200px"><span>Submit</span></button>
        </div>
    </form>
</div>
</body>







<!--The Controller-->
<script>
var app = angular.module('chemicals', []);
app.controller('myController', function ($scope) {

    // JSON ARRAY TO POPULATE TABLE.
    $scope.chemicalArray =[];

    // GET VALUES FROM INPUT BOXES AND ADD A NEW ROW TO THE TABLE.
    $scope.addRow = function () {
        if ($scope.name != undefined && $scope.dosage != undefined) {
            var chemical = [];
            chemical.name = $scope.name;
            chemical.dosage = $scope.dosage;

            $scope.chemicalArray.push(chemical);

            // CLEAR TEXTBOX.
            $scope.name = null;
            $scope.dosage = null;
        }
    };

    // Remove selected rows from table.
    $scope.removeRow = function () {
        var arrMovie = [];
        angular.forEach($scope.chemicalArray, function (value) {
            if (!value.Remove) {
                arrMovie.push(value);
            }
        });
        $scope.chemicalArray = arrMovie;
    };

});
</script>

<script>
function addRow() {
var table = document.getElementById("main");
var rws = table.rows;
var cols = table.rows[0].cells.length;
var row = table.insertRow(rws.length);
var cell;
for(var i=0;i<cols;i++){
    cell = row.insertCell(i);
    cell.innerHTML = '<input type="text" placeholder="Enter Value">';
    }
}
</script>


</html>