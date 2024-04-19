<?php
include('includes/connection.inc.php');
session_start();

use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- bootstrap css and icon-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="css/globalStyle.css">

    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body style="background-color: #F9F6EE;">

    <div class="d-flex justify-content-center align-items-center mt-5">
        <?php
        if (isset($_POST['btnLogin'])) {
            $emailOrUsername = $_POST['email_username'];
            $emailOrUsername_pattern = "/^[a-zA-Z]{2}[a-zA-Z0-9.@_\\-\\s]+$/";
            $emailOrUsername_result = preg_match($emailOrUsername_pattern, $emailOrUsername);

            $password = $_POST['password'];
            $password_pattern = "/.{8,}/";
            $password_result = preg_match($password_pattern, $password);

            if ($emailOrUsername_result == 1 && $password_result == 1) {
                // valid
                // check email
                if (filter_var($emailOrUsername, FILTER_VALIDATE_EMAIL)) {
                    //echo "Valid email address";

                    $checkEmail = mysqli_query($con, "SELECT * FROM `tbl_account` WHERE `email` = '$emailOrUsername' LIMIT 1");
                    $countEmail = mysqli_num_rows($checkEmail);

                    if ($countEmail > 0) {
                        //get user info from datbase
                        while ($row = mysqli_fetch_assoc($checkEmail)) {
                            $dbuserid = $row['userid'];
                            $dbUsername = $row['username'];
                            $dbEmail = $row['email'];
                            $dbPassword = $row['password'];
                            $dbGender = $row['gender'];
                        }

                        //password verification
                        $verifyPassword = password_verify($password, $dbPassword);

                        if ($verifyPassword == 1) {
                            //correct password input
                            $_SESSION['status'] = 200;
                            $_SESSION['userid'] = $dbuserid;
                            $_SESSION['username'] = $emailOrUsername;
                            $_SESSION['password'] = $dbPassword;
                            $_SESSION['email'] = $dbEmail;
                            $_SESSION['gender'] = $dbGender;

                            echo $dbuserid;

                            header('location: process.php');
                        } else {
                            echo '<div class="alert alert-warning fw-bold" role="alert">Invalid password</div>';
                        }
                    } else {
                        echo '<div class="alert alert-warning fw-bold" role="alert">Invalid email address</div>';
                    }
                } else {
                    // check username
                    if ($emailOrUsername_result == 1) {
                        // echo "Valid username";
                        $checkUsername = mysqli_query($con, "SELECT * FROM `tbl_account` WHERE `username` = '$emailOrUsername' LIMIT 1");
                        $countUsername = mysqli_num_rows($checkUsername);

                        if ($countUsername > 0) {
                            //get user info from datbase
                            while ($row = mysqli_fetch_assoc($checkUsername)) {
                                $dbuserid = $row['userid'];
                                $dbUsername = $row['username'];
                                $dbEmail = $row['email'];
                                $dbPassword = $row['password'];
                                $dbGender = $row['gender'];
                            }

                            //password verification
                            $verifyPassword = password_verify($password, $dbPassword);

                            if ($verifyPassword == 1) {
                                //correct password input\
                                $_SESSION['status'] = 200;
                                $_SESSION['userid'] = $dbuserid;
                                $_SESSION['username'] = $emailOrUsername;
                                $_SESSION['password'] = $dbPassword;
                                $_SESSION['email'] = $dbEmail;
                                $_SESSION['gender'] = $dbGender;

                                echo $dbuserid;

                                header('location: process.php');
                            } else {
                                echo '<div class="alert alert-warning fw-bold" role="alert">Invalid password</div>';
                            }
                        } else {
                            echo '<div class="alert alert-warning fw-bold" role="alert">Invalid username</div>';
                        }
                    } else {
                        echo '<div class="alert alert-warning fw-bold" role="alert">Not a valid username</div>';
                    }
                }
            } else {
                echo '<div class="alert alert-warning fw-bold" role="alert">Invalid input</div>';
            }
        }
        ?>
    </div>


    <div class=" d-flex justify-content-center align-items-center mt-5 p-3">
        <div class="card shadow-lg" style="width: 24rem;">
            <div class="card-header border-0 bg-dark">

            </div>
            <div class="card-body" style="font-family: Montserrat;">
                <h6 class="card-subtitle mb-2 text-body-secondary text-center"><small>Welcome to</small></h6>
                <h4 class=" card-title text-center fw-bold">Tiktalk <i class="bi bi-emoji-laughing"></i></h4>

                <form action="" method="POST" class="form-group">
                    <div class="mt-5 mb-3">
                        <div>
                            <small>
                                <p id="threechar" class="text-muted text-center fs-9">

                                </p>
                            </small>
                        </div>
                        <div>
                            <input class="form-control mb-3 fs-9" id="email_username" name="email_username" type="text" placeholder="Email or username" minlength="3" pattern="^[a-zA-Z]{2}[a-zA-Z0-9.@_\\-\\s]+$">
                        </div>
                        <div>
                            <small>
                                <p id="eightchar" class="text-muted text-center fs-9">

                                </p>
                            </small>
                        </div>
                        <div style="position: relative">

                            <input type="password" name="password" id="password" placeholder="Password" class="form-control mb-3 fs-9" pattern=".{8,}"><span class="icon position-absolute top-50 end-0 translate-middle-y p-3" id="showPasswordIcon"><i class=" bi bi-eye-slash-fill"></i></span>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-outline-dark btn-sm" id="btnLogin" name="btnLogin" type="submit">Login</button>
                    </div>
                    <div>
                        <!-- if empty, show this error -->
                        <small>
                            <p id="error-message" class="text-muted text-danger text-center mt-3"></p>
                        </small>
                    </div>
                    <hr>
                    <div class="text-center mt-3">
                        <a href="register.php" class="text-dark"><small>Create account</small></a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#btnLogin').click(function() {

                let email_username = $('#email_username').val().trim();
                let password = $('#password').val().trim();

                // Check if username or password is empty
                if (email_username === '' || password === '') {
                    alert('Username or password cannot be empty!');
                    return;
                }
            });
        });

        // check if the user enter more than 8 characters on password field or not 
        $(document).ready(function() {
            $('#email_username').on('input', function() {
                let email_username_Length = $(this).val().length;
                let requiredLength = 3;

                if ($(this).val() === '') {
                    $('#threechar').text('');
                } else if (email_username_Length < requiredLength) {
                    $('#threechar').text('Username should consist of a minimum of 3 characters(Start with letters).');
                } else {
                    $('#threechar').text('');
                }
            });

            $('#password').on('input', function() {
                let passwordLength = $(this).val().length;
                let requiredLength = 8;

                if ($(this).val() === '') {
                    $('#eightchar').text('');
                } else if (passwordLength < requiredLength) {
                    $('#eightchar').text('Password must be at least 8 characters long.');
                } else {
                    $('#eightchar').text('');
                }
            });
        });
    </script>


    <!-- show password -->
    <script>
        const passwordInput = document.getElementById('password');
        const showPasswordIcon = document.getElementById('showPasswordIcon');

        showPasswordIcon.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                showPasswordIcon.innerHTML = '<i class="bi bi-eye-fill"></i>';
            } else {
                passwordInput.type = 'password';
                showPasswordIcon.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
            }
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</body>

</html>