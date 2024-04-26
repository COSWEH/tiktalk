<?php
include("connection.inc.php");
session_start();

$getUserid = $_POST['id'];
$message = mysqli_real_escape_string($con, $_POST['message']);

$query = mysqli_query($con, "INSERT INTO `tbl_message`(`messageid`, `message`, `userid`, `send_at`) VALUES ('', '$message', '$getUserid', CURRENT_TIMESTAMP)");

if (!$query) {
    die('Error');
}
