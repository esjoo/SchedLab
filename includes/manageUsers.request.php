<?php
include '../db.php';
include_once('functions.php');
$userID = get_current_user_id();

// Manage requests
// Approve request
if(isset($_POST["request"]) && $_POST["request"]=="approve") {
    $approve_user = $_POST["request_user"];
    $sql_newlab = "SELECT lab.LabID, lab.LabName FROM lab JOIN users ON users.request=lab.LabID WHERE users.UserName='$approve_user'";
    $result = mysqli_query($conn, $sql_newlab);
    if ($r = mysqli_fetch_row($result)){
        $newLab = $r[0];
        $newLabName = $r[1];
    }
    $sql = "UPDATE users SET lab=$newLab, request=NULL WHERE UserName='$approve_user'";
    $result = mysqli_query($conn, $sql); 

    // Add action to log
    $action = "Approved move of ".$approve_user." to lab ".$newLabName."";
    $timestamp = date("Y-m-d G:i:s");
    $sql = "INSERT INTO logs(UserAction, Timestamp, Action) VALUES ($userID, '$timestamp', '$action')";
    $result = mysqli_query($conn, $sql); 
}
// Reject request
if(isset($_POST["request"]) && $_POST["request"]=="reject") {
    $reject_user = $_POST["request_user"];
    $sql = "UPDATE users SET request=NULL WHERE UserName='$reject_user'";
    $result = mysqli_query($conn, $sql); 

    $sql_newlab = "SELECT lab.LabName FROM lab JOIN users ON users.request=lab.LabID WHERE users.UserName='$reject_user'";
    $result = mysqli_query($conn, $sql_newlab);
    if ($r = mysqli_fetch_row($result)){
        $newLabName = $r[0];
    }

    // Add action to log
    $action = "Rejected move of ".$reject_user." to lab ".$newLabName."";
    $timestamp = date("Y-m-d G:i:s");
    $sql = "INSERT INTO logs(UserAction, Timestamp, Action) VALUES ($userID, '$timestamp', '$action')";
    $result = mysqli_query($conn, $sql); 
}
include "../closeDB.php";

header("Location: ../manageUsers.php");
die();
?>