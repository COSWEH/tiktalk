<?php
include('includes/connection.inc.php');
session_start();

$userid = $_SESSION['userid'];
$userotp = $_SESSION['userotp'];

$select = mysqli_query($con, "SELECT * FROM tbl_account WHERE userid = '$userid' LIMIT 1");
$count = mysqli_num_rows($select);

if ($count > 0) {
    while ($row = mysqli_fetch_assoc($select)) {
        $dbUsername = $row['username'];
        $dbEmail = $row['email'];
    }

    // verify otp code
} else {
    header('location: logout.php');
}

echo $userotp;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="css/globalStyle.css">

</head>

<body class="bg-secondary-subtle">

    <div class="d-flex justify-content-center align-items-center mt-5">
        <?php
        if (isset($_POST['btnVerify'])) {
            $otp = $_POST['otpv'];

            if ($userotp != $otp) {
                echo '<div class="alert alert-warning fw-bold" role="alert">Invalid OTP</div>';
            } else {
                header('location: index.php');
            }
        }
        ?>
    </div>

    <div class="d-flex justify-content-center align-items-center mt-5 p-3">
        <div class="card shadow-lg" style="width: 24rem;">
            <div class="card-header border-0 bg-dark">

            </div>
            <div class="card-body shadow-lg" style="font-family: Montserrat;">
                <h4 class=" card-title text-center fw-bold text-dark-emphasis">otp verification</h4>
                <h6 class="card-subtitle mb-2 text-body-secondary text-center"><small>Your OTP code sent to your email address * <?php echo $dbEmail; ?>.</small></h6>

                <form method="POST" class="form-group">
                    <div class="mt-5 mb-3">
                        <div style="position: relative">
                            <input type="text" name="otpv" id="otpv" placeholder="Enter your OTP code" class="form-control mb-3 fs-9">
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-outline-dark btn-sm" id="btnVerify" name="btnVerify">Verify</button>
                    </div>
                    <hr>
                    <div class="text-center mt-3">
                        <a href="logout.php" class="text-dark-emphasis"><small>Cancel</small></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>