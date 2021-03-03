<?php
include '../db.php';
include_once('functions.php');
$labID = get_current_user_lab();

if(isset($_POST["user"])){
    $user = $_POST["user"];
    $user_info = explode(',', $user);
    $sql = "UPDATE users SET lab=$labID WHERE UserName='$user_info[0]'";
    $result = mysqli_query($conn, $sql);
    $done = TRUE;
}

if(isset($_POST["record"])) {
    $rm_user = $_POST["record"];
    $sql = "UPDATE users SET lab=NULL WHERE UserName='$rm_user'";
    $result = mysqli_query($conn, $sql); 
    $done = TRUE;
}

include "../closeDB.php";

header("Location: ../manageUsers.php");
die();

$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}

?>