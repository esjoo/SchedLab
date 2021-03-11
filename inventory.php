<!DOCTYPE html>
<html>

<?php
include_once("header.php");
include_once("db.php");
?>

<h2 id="demofont3">Inventory</h2>
<body>
<link rel="stylesheet" href="style/protocol.css">

<div class="color">
    <?php
    //Creating table of inventory
    $sql = "SELECT InventName, Amount, Unit FROM Inventory ORDER BY InventName";
    $result = mysqli_query($conn,$sql);

    if (mysqli_num_rows($result) == 0) {
        print("No chemicals in inventory<br>\n");
    } else {
        echo "<table border='1' class='center'>";
        echo "<tr><th>Chemical</th><th>Amount in inventory</th><th>Alerts</th>";
        while($row = mysqli_fetch_row($result)) {
            echo "<tr><td>";
            echo $row[0];
            echo "</td><td>";
            echo $row[1] . " " . $row[2];
            echo "</td><td style='color:#FF0000'>";
            if ($row[1] <= 50) {
                echo "Running out of stock!";
            }
            echo "</td><tr>";
        }
    }
    echo "</table>";

    ?>
</div>

<h2 id="demofont3">Add or remove chemicals</h2>
<!--To add chemicals-->
<div class="color">
    <div class='add_chemicals' style="margin:0px">
    <form action="add_to_inventory.php" method="POST"> 
        <label name="chemical_name">Chemical:</label>
        <input type="text" name="chemical_name" required>
        <br><label name="amount">Amount (ml):</label>
        <select name="amount" style="width:200px"></br>
            <option selected="selected"></option>;
            <?php
            for($x=-500;$x<=10000;$x+=50) {
                print "<option value='$x'>$x</option>";
            }
            ?>
        </select><br>
        <button name="submit" type="submit" class="button"><span>Enter</span></button></br>
    </form>
    </div>
</div>
<h2 style='opacity:0'>Blank Space</h2>
</body>
</html>
