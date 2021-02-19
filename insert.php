<!DOCTYPE html>

<html>
<head>
    
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js"></script>
    
    <style>
        div {

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
        <form action="insert.inc.php" method='post'>
        
        <!-- Protocol name -->
            <div class="form-group form-inline">
                <label for="name">Protocol name:</label>
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

            <div ng-app="chemicals" ng-controller="myController">
                <label for="chemical">Chemicals & Dosages:</label>
                <ul>
                    <li>Chemical</li>
                        <li>
                            <select ng-model="name" class="selectpicker" placeholder="Chemical" name="chemical" data-live-search="true">
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
                </ul>

                <ul>
                    <li>Dosage</li>
                    <li><input type="number" ng-model="dosage" class="form-control" name="dosage" placeholder="dosage" /></li>
                </ul>

                <ul>
                    <li> </li><li><button ng-click="addRow()" type="button" class="btn btn-primary"> Add Row </button></li>
                </ul>

            <!--CREATE A TABLE-->
                <table> 
                    <tr>
                    <th>Num</th>
                        <th>Chemicals</th>
                            <th>Dosage</th>
                    </tr>

                    <tr ng-repeat="chemicals in chemicalArray">
                        <td><label>{{$index + 1}}</label></td>
                        <td><label>{{chemicals.name}}</label></td>
                        <td><label>{{chemicals.dosage}}</label></td>
                        <td><input type="checkbox" ng-model="chemicals.Remove"/></td>
                    </tr>
                </table>

                <div>      
                    <button ng-click="removeRow()" type="button" class="btn btn-primary">Remove Row</button>
                </div>            
            </div>



        <!-- Chemicals which haven't been in the db -->  
        <br>     
        If you haven't find the chimecals that you need:
            <div>
                <table id="main">
                    <th class="head">Chemicals</th>
                    <th class="head">Dosages</th>

                    <tr class="alt">
                        <td><input type="text" placeholder="Enter Value"></td>
                        <td><input type="number" placeholder="Enter Value"></td>
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