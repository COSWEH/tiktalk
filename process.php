<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

include('includes/connection.inc.php');
session_start();

$userid = $_SESSION['userid'];

$select = mysqli_query($con, "SELECT * FROM tbl_account WHERE userid = '$userid' LIMIT 1");
$count = mysqli_num_rows($select);

if (isset($_SESSION['status'])) {

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($select)) {
            $dbUsername = $row['username'];
            $dbEmail = $row['email'];
        }
    }


    $verification_code = mt_rand(100000, 999999);
    $message = "<h3>Your OTP number is <span class='fw-bold' style='font-size: 20px; font-family: Montserrat;'>$verification_code</span></h3>";

    // echo $userid;
    // echo $message;

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'tiktalkcompany6969@gmail.com';
    $mail->Password = 'wesuwhoykhaknjbl';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('tiktalkcompany6969@gmail.com');

    $mail->addAddress($dbEmail);

    $mail->isHTML(true);

    $mail->Subject = "TikTalk Verification Code";
    $mail->Body = $message;

    $mail->send();

    $_SESSION['userotp'] = $verification_code;
    header('location: verify_otp.php');
}
