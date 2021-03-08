<?php
echo '<link rel="stylesheet" href="style/main.css">';
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

echo "<h1 class='margin'>Account</h1>";
echo "<h2 class='margin'>Your information</h2>";
echo "<div class='part'>";
echo "<form method='POST'>";
while($row = $result->fetch_assoc()){
    echo "<lable name='first_name'>First name:</lable><br><input type='text' name='first_name' value=".$row['UserFirstName']."><br>";
    echo "<lable name='last_name'>Last name:</lable><br><input type='text' name='last_name' value=".$row['UserLastName']."><br>";
    echo "<p class='lable'>Username: </p><p>".$row['UserName']."</p>";
    echo "<lable name='email'>Email:</lable><br><input type='text' name='email' value=".$row['UserEmail']."><br>";
    if (isset($labName)){
        echo "<p class='lable'>Lab: </p><p>".$labName."</p>";
    }
}
echo "<div><button class='button submit' type='submit' name='submit'><span>Submit changes</span></button></div>";
echo "</form></div>";

if(isset($_POST['submit'])){
    $firstName=$_POST['first_name']; 
    $firstName=mysqli_real_escape_string($firstName);
    $lastName=$_POST['last_name']; 
    $lastName=mysqli_real_escape_string($lastName);
    $email=$_POST['email']; 
    $email=mysqli_real_escape_string($email);
    $sql = "UPDATE users SET UserFirstName='$firstName', UserLastName='$lastName', UserEmail='$email' WHERE UserID=$userID";
    $result = mysqli_query($conn, $sql);
    echo "<script type='text/javascript'>
        window.location=document.location.href;
        </script>";
}

echo "<h2 class='margin'>Change password</h2>";
echo "<div class='part'>";
echo "<form method='POST'>";
echo "<lable name='password'>New password:</lable><br><input placeholder='Password...' name='password' type='password'><br>";
echo "<lable name='confirm_password'>Confirm password:</lable><br><input type='password' placeholder='Confirm Password' name='confirm_password' required>";
echo "<div><button class='button submit' type='submit' name='new_password'><span>Change password</span></button><br></div>";
if(isset($_POST['new_password'])){
    if ($_POST['password']==$_POST['confirm_password']){
        $password = password_hash( mysqli_real_escape_string($conn,$_POST['password']),PASSWORD_DEFAULT);
        $sql = "UPDATE users SET UserPassword='$password' WHERE UserID=$userID";
        $result = mysqli_query($conn, $sql);
    } else {
        echo "<p>Passwords not matching</p>";
    }
}
echo "</div></form>";

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
