<!DOCTYPE html>
<html>

<?php
include_once("header.php");
include_once("db.php");
?>

<h1 style="color:black;margin-left:50px;margin-top:20px">Inventory</h1>
<body style="background-color:#FBF3F3">

<style>
th {
    padding: 18px 70px;
    font-size:18px;
    text-align: center;
    border:2px solid #e2a6a6;
    background-color: #FBF3F3;
    color: black;
    width:50%;
}
td {
    padding: 8px;
    text-align: center;
    border:2px solid #e2a6a6;
    background-color: #FBF3F3;
    width:50%;
    font-weight: bold;
    color: black;
}

table {
    margin-left: 50px;
    margin-top: 15px;

}

.add_chemicals {
    color: black;
    margin-left: 50px;
    margin-top: 10px;
    font-weight: bold;
}

.button {
    margin-top: 10px;
    background-color:#79ab79;
    border: none;
    color:white;
    font-size: 20px;
    text-align: center;
    border-radius: 12px;
    height: 40px;
    transition: all 0.5s;
    cursor: pointer;
    margin-left: 0px;
}

div.part {
    border-radius: 5px;
    background-color: #f5e0e0;
    padding: 20px;
}

</style>

<div class="part">
<?php
//Creating table of inventory
$sql = "SELECT InventName, Amount, Unit FROM Inventory ORDER BY InventName";
$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result) == 0) {
    print("No chemicals in inventory<br>\n");
} else {
    echo "<table border='1' class='center'>";
    echo "<tr><th>Chemical</th><th>Amount in inventory</th>";
    while($row = mysqli_fetch_row($result)) {
        echo "<tr><td>";
        echo $row[0];
        echo "</td><td>";
        echo $row[1] . " " . $row[2];
        echo "</td><tr>";
    }
}
echo "</table>";

?>
</div>

<h2 style="color:black;margin-left:50px;margin-top:20px">Add or remove chemicals</h2>

<!--To add chemicals-->
<div class="part">
<div class='add_chemicals'>
<form action="add_to_inventory.php" method="POST"> 
    <label name="chemical_name">Chemical:</label><br>
    <input type="text" name="chemical_name" style="border:2px solid #e2a6a6"><br>
    <label name="amount">Amount (ml):</label><br>
    <select name="amount" style="border:2px solid #e2a6a6"><br>
        <option selected="selected"></option>;
        <?php
        for($x=-500;$x<=10000;$x+=50) {
            print "<option value='$x'>$x</option>";
        }
        ?>
    </select><br>
    <input class = "button" type="submit" value="Enter">

</form>
</div>
</div>

</body>
</html>
