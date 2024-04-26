<?php
include("connection.inc.php");
session_start();
// $getUserid = $_SESSION['userid'];

?>

<div class="list-group">
    <?php

    $query = "SELECT m.messageid, m.message, m.userid, m.send_at, a.username, a.gender 
          FROM tbl_message AS m 
          INNER JOIN tbl_account AS a ON m.userid = a.userid";

    $result = mysqli_query($con, $query);

    while ($data = mysqli_fetch_assoc($result)) {
        $mid = $data['messageid'];
        $message = $data['message'];
        $username = strtolower($data['username']);
        $username = ucwords($username);
        $gender = $data['gender'];
        $getTime = $data['send_at'];

        $get_Time_And_Day = new DateTime($getTime);

        if ($gender == "male") {
            $getGenderIcon = "<i class='bi bi-gender-male fs-9'></i>";
        } else {
            $getGenderIcon = "<i class='bi bi-gender-female fs-9'></i>";
        }
    ?>
        <div class="card border-dark ms-auto rounded-3 bg-secondary-subtle">
            <div class="card-body text-dark-emphasis">
                <h6><?php echo $username . " " . $getGenderIcon; ?></h6>
                <p class="card-text fs-6" style="font-family: Roboto;">
                    <?php echo "$message "; ?>
                </p>
            </div>
        </div>
        <p class='fs-9 ms-auto'>
            <small>
                <?php echo $get_Time_And_Day->format('h:i A D'); ?>
            </small>
        </p>
        <hr>

    <?php
    }
    ?>

</div>