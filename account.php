<?php
echo '<link rel="stylesheet" href="style/protocol.css">';
include "header.php";
include "db.php";
include_once "includes/functions.php";

$labID = get_current_user_lab();
$sql = "SELECT LabName FROM lab WHERE LabID=$labID";
$result = mysqli_query($conn, $sql);
if ($r = mysqli_fetch_row($result)){
    $labName = $r[0];
}

$userID = get_current_user_id();
$sql = "SELECT * from users WHERE UserID=$userID";
$result = mysqli_query($conn, $sql);

echo "<h1 id=demofont3>Account</h1>";
echo "<div style=text-align:center>";
echo "<h2 id=demofont1>Your information</h2>";
echo "<div class='color'>";
echo "<form method='POST'>";
while($row = $result->fetch_assoc()){
    echo "<lable name='first_name'>First name:</lable><br><input type='text' name='first_name' value=".$row['UserFirstName']."><br>";
    echo "<lable name='last_name'>Last name:</lable><br><input type='text' name='last_name' value=".$row['UserLastName']."><br>";
    echo "<p>Username: </p><p>".$row['UserName']."</p>";
    echo "<lable name='email'>Email:</lable><br><input type='text' name='email' value=".$row['UserEmail']."><br>";
    if (isset($labName)){
        echo "<p>Lab: </p><p>".$labName."</p>";
    }
}
echo "<button class='button submit' type='submit' name='submit'><span>Submit changes</span></button>";
echo "</form></div>";

if(isset($_POST['submit'])){
    $firstName=$_POST['first_name']; 
    $firstName=mysqli_real_escape_string($conn, $firstName);
    $lastName=$_POST['last_name']; 
    $lastName=mysqli_real_escape_string($conn, $lastName);
    $email=$_POST['email']; 
    $email=mysqli_real_escape_string($conn, $email);
    $sql = "UPDATE users SET UserFirstName='$firstName', UserLastName='$lastName', UserEmail='$email' WHERE UserID=$userID";
    $result = mysqli_query($conn, $sql);
    echo "<script type='text/javascript'>
        window.location=document.location.href;
        </script>";
}

echo "<h2 id=demofont1>Change password</h2>";
echo "<div class='color'>";
echo "<form method='POST'>";
echo "<lable name='password'>New password:</lable><br><input placeholder='Password...' name='password' type='password'><br>";
echo "<lable name='confirm_password'>Confirm password:</lable><br><input type='password' placeholder='Confirm Password' name='confirm_password' required><br>";
echo "<button class='button submit' type='submit' name='new_password'><span>Change password</span></button>";
if(isset($_POST['new_password'])){
    if ($_POST['password']==$_POST['confirm_password']){
        $password = password_hash( mysqli_real_escape_string($conn,$_POST['password']),PASSWORD_DEFAULT);
        $sql = "UPDATE users SET UserPassword='$password' WHERE UserID=$userID";
        $result = mysqli_query($conn, $sql);
    } else {
        echo "<p>Passwords not matching</p>";
    }
}
echo "</form></div>";
echo "<h2 style='opacity:0'> Name </h2>";
echo"</div>";

echo '<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(event) { 
    var scrollpos = localStorage.getItem("scrollpos");
    if (scrollpos) window.scrollTo(0, scrollpos);
});

window.onbeforeunload = function(e) {
    localStorage.setItem("scrollpos", window.scrollY);
};
</script>';
include "closeDB.php";
?>
