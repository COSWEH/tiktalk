<?php
include("connection.inc.php");
session_start();

$getUserid = $_POST['id'];
$message = mysqli_real_escape_string($con, $_POST['message']);

date_default_timezone_set('Asia/Manila');
$send_at = date("Y-m-d g:i:s");

$query = mysqli_query($con, "INSERT INTO `tbl_message`(`messageid`, `message`, `userid`, `send_at`) VALUES ('', '$message', '$getUserid', '$send_at')");

if (!$query) {
    die('Error');
}
