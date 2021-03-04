<?php 

include 'db.php';

$monday = date("Y-m-d", strtotime("next Monday"));
$tuesday = date("Y-m-d", strtotime("next Monday + 1 days"));
$wednesday = date("Y-m-d", strtotime("next Monday + 2 days"));
$thursday = date("Y-m-d", strtotime("next Monday + 3 days"));
$friday = date("Y-m-d", strtotime("next Monday + 4 days"));

//Get SupNames for all chemicals that are in experiments next week, sort by SupID
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

$ConsumeAmount = mysqli_query($conn,"SELECT ConsumeAmount, SupID FROM Experiment WHERE CalenID IN (
    SELECT CalenID FROM UserCalendar 
    WHERE FromDateTime LIKE '$monday%' 
    OR FromDateTime LIKE '$tuesday%'
    OR FromDateTime LIKE '$wednesday%'
    OR FromDateTime LIKE '$thursday%'
    OR FromDateTime LIKE '$friday%');");
    
$amounts = array();
$SupID = array();
while($row = mysqli_fetch_row($ConsumeAmount)){
    array_push($amounts, $row["0"]);
    array_push($SupID, $row["1"]);
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

?>

<html>

<?php
include_once("header.php");
include_once("db.php");

$nextweek = date('W', strtotime('next week'));
?>

<h1 style="color:black;margin-left:50px;margin-top:20px">Chemical consumption for week <?php echo $nextweek ?></h1>
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

</style>

<div class="part">
<?php

echo "<table border='1' class='center'>";
echo "<tr><th>Chemical</th><th>Amount to be used (ml)</th>";

$i = 0;
foreach ($add_SupID as $value) {
    echo "<tr><td>"."$chemicals[$i]"."</td><td>"."$value"."</td></tr>";
    $i++;
}

echo "</table>";

?>
</div>

</body>
</html>