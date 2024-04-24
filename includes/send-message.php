<?php
include("connection.inc.php");
session_start();

$getUserid = $_POST['id'];
$message = mysqli_real_escape_string($con, $_POST['message']);

$send_at = date("Y-m-d h:i:s");

$query = mysqli_query($con, "INSERT INTO `tbl_message`(`messageid`, `message`, `userid`, `send_at`) VALUES ('', '$message', '$getUserid', '$send_at')");

if (!$query) {
    die('Error');
}
