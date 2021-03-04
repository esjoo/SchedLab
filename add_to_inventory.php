<?php
include_once("db.php");
$chemical_name=$_POST["chemical_name"];
$chemical_name=mysqli_real_escape_string($conn,$chemical_name);
$amount=$_POST["amount"];
$amount=mysqli_real_escape_string($conn,$amount);
$amount = intval($amount);


$current_amount_result = mysqli_query($conn, "SELECT Amount FROM Inventory WHERE InventName='$chemical_name'");


if (mysqli_num_rows($current_amount_result) > 0) {
    while ($current_amount = mysqli_fetch_row($current_amount_result)) {
        $current_amount = $current_amount[0];
        $current_amount = intval($current_amount);
        $new_amount = $current_amount + $amount;
    }
    $result = mysqli_query($conn, "UPDATE Inventory SET Amount = $new_amount WHERE InventName='$chemical_name'");   
    //Get redirected back to the inventory page
    header("Location: http://localhost/ims/schedlab/schedlab_vers2/inventory.php");

} else {
    $result = mysqli_query($conn, "INSERT INTO Inventory (InventName, Amount, Unit) VALUES ('$chemical_name', $amount, 'ml')");
    //Get redirected back to the inventory page
    header("Location: http://localhost/ims/schedlab/schedlab_vers2/inventory.php");
}

?>
