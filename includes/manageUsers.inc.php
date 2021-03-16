<?php
include '../db.php';
include_once('functions.php');
$labID = get_current_user_lab();
$sql = "SELECT LabName FROM lab WHERE LabID=$labID";
$result = mysqli_query($conn, $sql);
if ($r = mysqli_fetch_row($result)){
    $labName = $r[0];
}
$userID = get_current_user_id();

// Add user
if(isset($_POST["user"])){
    $user = $_POST["user"];
    $user_info = explode(',', $user);
    $user = mysqli_real_escape_string($conn, $user_info[0]);

    // Check if user has an assigned lab
    $sql = "SELECT lab FROM users WHERE UserName='$user'";
    $result = mysqli_query($conn, $sql);
    if ($r = mysqli_fetch_row($result)){
        $userLab = $r[0];
    }
    if ($userLab == 0){
        // Add unassigned user to the lab
        $sql = "UPDATE users SET lab=$labID WHERE UserName='$user'";
        $result = mysqli_query($conn, $sql);

        // Add action to log
        $action = "Added ".$user." to lab ".$labName;
        $timestamp = date("Y-m-d G:i:s");
        $sql = "INSERT INTO logs(UserAction, Timestamp, Action) VALUES ($userID, '$timestamp', '$action')";
        $result = mysqli_query($conn, $sql);

    } else {
        // Request assigned user to be moved into the lab
        $sql = "UPDATE users SET request=$labID WHERE UserName='$user'";
        $result = mysqli_query($conn, $sql);

        // Add action to log
        $action = "Requested to move ".$user." to lab ".$labName;
        $timestamp = date("Y-m-d G:i:s");
        $sql = "INSERT INTO logs(UserAction, Timestamp, Action) VALUES ($userID, '$timestamp', '$action')";
        $result = mysqli_query($conn, $sql); 
    }
}

// Remove user
if(isset($_POST["record"])) {
    $rm_user = $_POST["record"];
    $sql = "UPDATE users SET lab=0 WHERE UserName='$rm_user'";
    $result = mysqli_query($conn, $sql); 

    // Add action to log
    $action = "Removed ".$rm_user." from lab ".$labName;
    $timestamp = date("Y-m-d G:i:s");
    $sql = "INSERT INTO logs(UserAction, Timestamp, Action) VALUES ($userID, '$timestamp', '$action')";
    $result = mysqli_query($conn, $sql); 
}

include "../closeDB.php";

header("Location: ../manageUsers.php");
die();
?>
