<?php
include('includes/connection.inc.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- bootstrap css and icon-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="css/globalStyle.css">

</head>

<body class="bg-secondary-subtle">

    <div class="d-flex justify-content-center align-items-center mt-5">
        <?php
        if (isset($_POST['btnRegister'])) {
            $username = $_POST['username'];
            $username_pattern = "/^[a-zA-Z]{2}[a-zA-Z0-9.@_\\-\\s]+$/";
            $username_result = preg_match($username_pattern, $username);

            $email = $_POST['email'];
            $email_pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
            $email_result = preg_match($email_pattern, $email);

            $password = $_POST['password'];
            $password_pattern = "/.{8,}/";
            $password_result = preg_match($password_pattern, $password);

            $gender = $_POST['gender'];

            if ($username_result == 1 && $email_result == 1 && $password_result == 1) {
                //valid
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    //valid email

                    //hash password
                    $password = password_hash($password, PASSWORD_DEFAULT);

                    //check if the username is already exist
                    $checkUsername = mysqli_query($con, "SELECT * FROM tbl_account WHERE username = '$username' LIMIT 1");
                    $countUsername = mysqli_num_rows($checkUsername);

                    //check if the email address is already exist
                    $checkEmail = mysqli_query($con, "SELECT * FROM tbl_account WHERE email = '$email' LIMIT 1");
                    $countEmail = mysqli_num_rows($checkEmail);

                    if ($countUsername == 1) {
                        echo '<div class="alert alert-warning fw-bold" role="alert">';
                        echo 'The username ';
                        echo $username . ' is already exist.</div>';
                    } elseif ($countEmail == 1) {
                        echo '<div class="alert alert-warning fw-bold" role="alert">';
                        echo 'The email ';
                        echo $email . ' is already exist.</div>';
                    } else {
                        //if non is existed, proceed to insert
                        $insert = mysqli_query($con, "INSERT INTO tbl_account (userid, username, email, password, gender) VALUES ('', '$username', '$email', '$password', '$gender')");

                        if (!$insert) {
                            die('Unable to register.');
                        } else {
                            echo "<script>alert('Successfully registered.')</script>";
                            header('location: login.php');
                        }
                    }
                }
            } else {
                echo '<div class="alert alert-warning fw-bold" role="alert">Invalid input</div>';
            }
        }
        ?>
    </div>

    <div class="d-flex justify-content-center align-items-center mt-5 p-3">
        <div class="card shadow-lg" style="width: 24rem;">
            <div class="card-header border-0 bg-dark">

            </div>

            <div class="card-body shadow-lg" style="font-family: Montserrat, Arial;">
                <h3 class="card-title text-center fw-bold mt-2 text-dark-emphasis">Let's Start</h3>
                <form action="" method="POST" class="form-group">
                    <div class="mt-5 mb-3">
                        <div>
                            <input class="form-control mb-3 fs-9" name="username" type="text" placeholder="Username" minlength="3" required pattern="^[a-zA-Z]{2}[a-zA-Z0-9.@_\\-\\s]+$">
                        </div>
                        <div>
                            <input class="form-control mb-3 fs-9" name="email" type="email" placeholder="Email" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                        </div>
                        <div>
                            <small>
                                <!-- show password condition -->
                                <p id="eightchar" class="text-muted text-center fs-9">

                                </p>
                            </small>
                        </div>
                        <div style="position: relative">

                            <input type="password" name="password" id="password" placeholder="Password" class="form-control mb-3 fs-9" pattern=".{8,}"><span class="icon position-absolute top-50 end-0 translate-middle-y p-3" id="showPasswordIcon"><i class=" bi bi-eye-slash-fill"></i></span>
                        </div>

                        <div class="container text-dark-emphasis">
                            <p class="mt-3 fs-9">Gender:</p>
                            <div class="form-group">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="gender" id="male" required value="male">
                                    <small>
                                        <label class="form-check-label fs-9" for="male">
                                            Male
                                        </label>
                                    </small>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="gender" id="female" required value="female">
                                    <small>
                                        <label class="form-check-label fs-9" for="female">
                                            Female
                                        </label>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-grid gap-2">
                        <button class="btn btn-dark btn-sm" name="btnRegister" type="submit">Register</button>
                        <a href="login.php" class="btn btn-outline-dark btn-sm">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- password -->
    <script>
        $(document).ready(function() {
            $('#password').on('input', function() {
                let passwordLength = $(this).val().length;
                let requiredLength = 8;

                if ($(this).val() === '') {
                    $('#eightchar').text('');
                } else if (passwordLength < requiredLength) {
                    $('#eightchar').text('Create a password at least 8 characters long.');
                } else {
                    $('#eightchar').text('');
                }
            });
        });
    </script>

    <script>
        // eye icon for password field
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