<style>
/* Page styling */
div {
    margin-bottom:25px;
    margin-right:25px;
    margin-left:25px;
}

div.part {
    border-radius: 5px;
    background-color: #f5e0e0;
    padding: 20px;
}

a:hover {
    cursor: pointer;
    background-color: yellow;
}

table, input {
    margin-top:15px;
    margin-bottom:15px;
    text-align:left;
}

table, td, th {
    margin:25px;
    padding:4px 20px;
    border:2px solid #e2a6a6;
    background-color: #FBF3F3;
}

input[type=text] {
    border: 2px solid #e2a6a6;
}

input[type=number] {
    border: 2px solid #e2a6a6;
}

textarea{
    border: 2px solid #e2a6a6;
}

select{
    border: 2px solid #e2a6a6;
}

h1.margin, h2.margin {
    margin-top:25px;
    margin-bottom:25px;
    margin-right:50px;
    margin-left:50px;
    color:black;
}

h5.margin {
    margin-top:1px;
    margin-bottom:1px;
    color:black;
}

h6.font {
    margin:0px;
    color:black;
}

.button, .submit {
    background-color:#79ab79;
    border: none;
    color:white;
    font-size: 20px;
    text-align: center;
    border-radius: 12px;
    height: 40px;
    transition: all 0.5s;
    cursor: pointer;
}

.button span {
    cursor: pointer;
    display: inline-block;
    position: relative;
    transition: 0.5s;
}

.button span:after {
    content: '\00bb';
    position: absolute;
    opacity: 0;
    top: 0;
    right: -20px;
    transition: 0.5s;
}

.button:hover span {
    padding-right: 25px;
}

.button:hover span:after {
    opacity: 1;
    right: 0;
}

p{
    color:black;
}

p.lable {
    color:#e2a6a6;
}

.dropbtn {
    background-color: #4CAF50;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
}

.dropdown {
    position: relative;
    display: inline-block; 
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
</style>

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
    echo "<p class='lable'>Lab: </p><p>".$labName."</p>";
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
echo "<div><button class='button submit' type='submit' name='new_password'><span>Change password</span></button><br></div>";
echo "</div></form>";
if(isset($_POST['new_password'])){
    $password = password_hash( mysqli_real_escape_string($conn,$_POST['password']),PASSWORD_DEFAULT);
    $sql = "UPDATE users SET UserPassword='$password' WHERE UserID=$userID";
    $result = mysqli_query($conn, $sql);
}
include "closeDB.php";
include "footer.php";
?>