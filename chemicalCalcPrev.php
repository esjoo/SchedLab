<?php 

include 'db.php';

$monday = date("Y-m-d", strtotime("Monday last week"));
$tuesday = date("Y-m-d", strtotime("Tuesday last week"));
$wednesday = date("Y-m-d", strtotime("Wednesday last week"));
$thursday = date("Y-m-d", strtotime("Thursday last week"));
$friday = date("Y-m-d", strtotime("Friday last week"));

//Get SupNames for all chemicals that are in experiments next week 
$SupNames = mysqli_query($conn,"SELECT SupName FROM Supplement WHERE SupID IN (
SELECT SupID FROM Experiment WHERE CalenID IN (
SELECT CalenID FROM UserCalendar 
WHERE FromDateTime LIKE '$monday%' 
OR FromDateTime LIKE '$tuesday%'
OR FromDateTime LIKE '$wednesday%'
OR FromDateTime LIKE '$thursday%'
OR FromDateTime LIKE '$friday%')) ORDER BY SupID;");

$chemicals = array();
while($row = mysqli_fetch_row($SupNames)){
    array_push($chemicals, $row["0"]);
}

$ConsumeAmount = mysqli_query($conn,"SELECT ConsumeAmount, SupID, ExpNum FROM Experiment WHERE CalenID IN (
    SELECT CalenID FROM UserCalendar 
    WHERE FromDateTime LIKE '$monday%' 
    OR FromDateTime LIKE '$tuesday%'
    OR FromDateTime LIKE '$wednesday%'
    OR FromDateTime LIKE '$thursday%'
    OR FromDateTime LIKE '$friday%') ORDER BY SupID;");

$amounts = array();
$SupID = array();
$ExpNum = array();
while($row = mysqli_fetch_row($ConsumeAmount)){
    array_push($amounts, $row["0"]);
    array_push($SupID, $row["1"]);
    array_push($ExpNum,$row["2"]);
}

$key_array = array();
$prev_checked = array();
foreach ($SupID as $value)  {
    $keys = array_keys($SupID, $value);
    array_push($key_array, $keys);
    
}
//$new_key_array contains the indexes of the SupIDs that are the same 
$new_key_array = array();
foreach ($key_array as $value) {
    if (count($value) > 1) {
        array_push($new_key_array, $value);
    }
}
//Remove duplicates
$new_key_array = array_unique($new_key_array, SORT_REGULAR);

//Add up amounts when there are several experiments using the same chemical
//add_SupID will contain chemicals that are in several experiments 
$add_SupID = array();
foreach ($new_key_array as $value) {
    $val = 0;
    foreach ($value as $ind) {
        $val += $amounts[$ind];

    }
    $add_SupID[$SupID[$value[0]]] = $val;
}

//Put all chemicals in add_SupID and sort by key(SupID) 
$i = 0;
foreach ($SupID as $value) {
    if (!array_key_exists($value, $add_SupID)) {
        $add_SupID[$value] = $amounts[$i];
    }
    $i++;
}
ksort($add_SupID);

$SupID_unique = array_unique($SupID, SORT_REGULAR);
$chemicals = array_combine($SupID_unique, $chemicals);

?>

<html>

<?php
include_once("header.php");
include_once("db.php");

$lastweek = date('W', strtotime('last week'));
?>

<h1 style="color:black;margin-left:50px;margin-top:20px">Chemical consumption for week <?php echo $lastweek ?></h1>
<body style="background-color:#FBF3F3">

<style>
th {
    padding: 18px 70px;
    font-size:18px;
    text-align: center;
    border:2px solid #e2a6a6;
    background-color: #518451; /* added some green */
    color: black;
    width:50%;
}
td {
    padding: 8px;
    text-align: center;
    color: black; /* pink text was kinda hard to see */
    border:2px solid #e2a6a6;
    background-color: #FBF3F3;
    width:50%;
    font-weight: bold;
}
table {
    margin-left: 50px;
    margin-top: 15px;

}
div.part {
    border-radius: 5px;
    background-color: #f5e0e0;
    padding: 20px;
}
div {
    margin-bottom:25px;
    margin-right:25px;
    margin-left:25px;
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

h1.margin, h2.margin {
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

.button { /* Removed .submit, made search button look weird */
    background-color:#79ab79;
    border: none;
    color:white;
    font-size: 20px;
    text-align: center;
    border-radius: 12px;
    height: 40px;
    transition: all 0.5s;
    cursor: pointer;
    padding: 8px 15px; /* Had to add this line so the buttons would look nice */
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

.dropbtn {
    background-color: #4CAF50;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
}

.dropdown {
    position: relative;
    display: inline-block; 
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}

</style>

<div class="part">

<a class="button" href="chemicalCalcThis.php"><span>This week</span></a>
<a class="button" href="chemicalCalcNext.php"><span>Next week</span></a>

<div class="search-box">
    <form action="chemicalCalcPrev.php" method="POST">
        <input style="height:40px" type="text" autocomplete="off" placeholder="Search chemical" id="search" name="search" />
        <button class="submit"><span>Search</span></button>
        <div class="result"></div>
    </form>
</div>

<?php 
include "db.php";

error_reporting(0);
ini_set('display_errors', 0);

$search_result = $_POST['search'];
$result = mysqli_query($conn, "SELECT SupID FROM Supplement WHERE SupName LIKE '$search_result'");

while ($row = mysqli_fetch_row($result)){
    echo "<table border='1' class='center'>";
    echo "<tr><th>Chemical</th><th>Amount to be used (ml)</th>";
    echo "<tr><td>".$chemicals[$row['0']]."</td><td>".$add_SupID[$row['0']]."</td></tr>";
}

echo "</table>";

include "closeDB.php"; 

if ($search_result == "") { 
    echo "<table border='1' class='center'>";
    echo "<tr><th>Chemical</th><th>Amount to be used (ml)</th>";

    foreach ($add_SupID as $value) {
        $key = array_search($value,$add_SupID);
        echo "<tr><td>"."$chemicals[$key]"."</td><td>"."$value"."</td></tr>";
    }

    echo "</table>";
}

?>
</div>
</body>
</html>

<script type="text/javascript">
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("livesearchFORchemicalCalculation.php", {term: inputVal}).done(function(data){
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