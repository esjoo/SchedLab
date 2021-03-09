

<?php 

include 'db.php';

$monday = date("Y-m-d", strtotime("Monday this week"));
$tuesday = date("Y-m-d", strtotime("Tuesday this week"));
$wednesday = date("Y-m-d", strtotime("Wednesday this week"));
$thursday = date("Y-m-d", strtotime("Thursday this week"));
$friday = date("Y-m-d", strtotime("Friday this week"));

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
<?php
    include_once("header.php");
    include_once("db.php");

    $thisweek = date('W', strtotime('this week'));
?>

<html>
<link rel="stylesheet" href="style/protocol.css">
<h2>Chemical consumption for week <?php echo $thisweek ?></h2>
<body>

<div class="color">

    <a class="button" style="display:block font-size:15px" href="chemicalCalcPrev.php"><span>Prev week</span></a>
    <a class="button" style="font-size:15px" href="chemicalCalcNext.php"><span>Next week</span></a>

    <div class="search-box" style="margin:0px">
        <form action="chemicalCalcThis.php" method="POST">
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
        echo "<table>";
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