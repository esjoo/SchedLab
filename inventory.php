<!DOCTYPE html>
<html>

<?php
include_once("header.php");
include_once("db.php");
?>

<h1 style="color:#E9C5C5;font-family:Raleway;text-align:center;margin-top:20px">Inventory</h1>
<body style="background-color:#FBF3F3">

<style>
th {
    padding: 18px 80px;
    background-color: white;
    font-family:"Raleway";
    font-size:18px;
}
td {
    padding: 8px;
    text-align: center;
    background-color: white;
    font-family:"Raleway";
}

table.center {
    margin-left: auto;
    margin-right: auto;
    margin-top: 15px;
}

</style>

<?php
//Creating table of inventory
$sql = "SELECT InventID, Amount, Unit FROM Inventory";
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



<!--To add chemicals-->
<form action="add_to_inventory.php" method="POST"> <!--Don't manage to center these-->
    <label name="chemical_name" style="margin-left:100px;margin-top:20px">Chemical:</label><br>
    <input type="text" name="chemical_name" style="margin-left:100px"><br>
    <label name="amount" style="margin-left:100px">Amount:</label><br>
    <select name="amount" style="margin-left:100px"><br>
        <?php
        for($x=10;$x<=10000;$x+=10) {
            print "<option value='$x'>$x</option>";
        }
        ?>
    </select><br>
    <input type="submit" value="Add" style="margin-top:10px;margin-left:100px">

</form>

</body>
</html>
