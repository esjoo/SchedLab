<!DOCTYPE html>
<html>


<body style="background-color:#FBF3F3">

<?php
//Error handling function
function amountError($errno, $errstr) {
    echo "<b>Error: </b> $errstr<br>";
    die();
}

//Set error handler
set_error_handler("amountError", E_USER_WARNING);


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
    if ($new_amount < 0) {
        trigger_error("The amount of " . $chemical_name . " cannot be lower than zero!", E_USER_WARNING);
        echo "<form action='inventory.php'>";
        echo "<input class='button' type='submit' value='Go back'>";
        echo "</form>";
    } else {
        $result = mysqli_query($conn, "UPDATE Inventory SET Amount = $new_amount WHERE InventName='$chemical_name'");   
        //Get redirected back to the inventory page
        header("location: " . $_SERVER['HTTP_REFERER']);
        }
} else {
    if ($amount <0) {
        trigger_error("The amount of " . $chemical_name . " cannot be lower than zero!", E_USER_WARNING);
        echo "<form action='inventory.php'>";
        echo "<input class='button' type='submit' value='Go back'>";
        echo "</form>"; 
    }else {
        $result = mysqli_query($conn, "INSERT INTO Inventory (InventName, Amount, Unit) VALUES ('$chemical_name', $amount, 'ml')");
        //Get redirected back to the inventory page
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
}

?>

</body>
</html>
