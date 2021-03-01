
<?php
//include_once("db.php");
$chemical_name=$_POST["chemical_name"];
$chemical_name=mysqli_real_escape_string($conn,$chemical_name);
$amount=$_POST["amount"];
$amount=mysqli_real_escape_string($conn,$amount);

//Need a way to be redirected directly back to the inventory page

//Change this a bit when the new attribute chemical_name is added!! Doesn't work :( ask about this!
$current_amount = mysqli_query($conn, "SELECT Amount FROM Inventory WHERE InventID=$chemical_name");
$new_amount = $current_amount + $amount;


$result = mysqli_query($conn, "UPDATE Inventory SET Amount = $new_amount WHERE InventID=$chemical_name");

?>
