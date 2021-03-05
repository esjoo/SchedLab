<?php
include '../db.php';
include_once('functions.php');
$labName = get_current_user_labName();
$userID = get_current_user_id();

// Manage requests
// Approve request
if(isset($_POST["request"]) && $_POST["request"]=="approve") {
    $approve_user = $_POST["request_user"];
    $sql_newlab = "SELECT request FROM users WHERE UserName='$approve_user'";
    $result = mysqli_query($conn, $sql_newlab);
    if ($r = mysqli_fetch_row($result)){
        $newLab = $r[0];
    }
    $sql = "UPDATE users SET lab=$newLab, request=NULL WHERE UserName='$approve_user'";
    $result = mysqli_query($conn, $sql); 
    echo $approve_user.", ".$newLab;

    // Add action to log
    $action = "Approved move of ".$approve_user." from lab ".$labName." to lab ".$newLab;
    $timestamp = date("Y-m-d G:i:s");
    $sql = "INSERT INTO logs(UserAction, Timestamp, Action) VALUES ($userID, '$timestamp', '$action')";
    $result = mysqli_query($conn, $sql); 
}
// Reject request
if(isset($_POST["request"]) && $_POST["request"]=="reject") {
    $reject_user = $_POST["request_user"];
    $sql = "UPDATE users SET reject=NULL WHERE UserName='$reject_user'";
    $result = mysqli_query($conn, $sql); 

    // Add action to log
    $action = "Rejected move of ".$reject_user." from lab ".$labName;
    $timestamp = date("Y-m-d G:i:s");
    $sql = "INSERT INTO logs(UserAction, Timestamp, Action) VALUES ($userID, '$timestamp', '$action')";
    $result = mysqli_query($conn, $sql); 
}
include "../closeDB.php";

//header("Location: ../manageUsers.php");
//die();
?>