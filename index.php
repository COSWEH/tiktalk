<?php
include('includes/connection.inc.php');
session_start();


$getUserid = $_SESSION['userid'];
$username = "";
$email = "";
$gender = "";

$selectUser = mysqli_query($con, "SELECT * FROM `tbl_account` WHERE `userid` = '$getUserid' LIMIT 1");
$countUsern = mysqli_num_rows($selectUser);

if ($countUsern > 0) {
    //get user info from datbase
    while ($row = mysqli_fetch_assoc($selectUser)) {
        $username = $row['username'];
        $email = $row['email'];
        $gender = $row['gender'];
    }
} else {
    header('location: logout.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TikTalk</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="css/globalStyle.css">

    <!-- jquery ajax cdn -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body style="font-family: Montserrat, Arial;" class="bg-dark">
    <nav class="navbar  sticky-top navbar-expand-md bg-secondary-subtle">
        <div class="container">
            <a class="navbar-brand fs-2 text-dark-emphasis" href="index.php">TikTalk</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span><i class="bi bi-list fs-1"></i></span>
            </button>
            <div class=" collapse navbar-collapse" id="navbarSupportedContent">
                <div class="btn-group ms-auto">
                    <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-fill-gear fs-6"></i>
                        Account
                    </button>
                    <ul class="dropdown-menu bg-secondary-subtle" style="min-width: 246px;">
                        <li class="nav-item mx-2">
                            <a class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover fs-6 text-dark-emphasis" aria-current="page">
                                <span class="fs-9">Username:</span>
                                <?php
                                echo ucwords($username);
                                ?>
                            </a>
                        </li>
                        <li class="nav-item mx-2">
                            <!-- email -->
                            <a class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover fs-6 text-dark-emphasis" aria-current="page">
                                <span class="fs-9">Email:</span>
                                <?php
                                echo ucwords($email);
                                ?>
                            </a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover fs-6 text-dark-emphasis" aria-current="page">
                                <span class="fs-9">Gender:</span>
                                <?php
                                echo ucwords($gender);
                                ?>
                            </a>
                        </li>
                        <!-- logout button -->
                        <div class="mt-4 mx-2">
                            <a href="logout.php" class="btn btn-dark btn-outline-dark btn-sm text-light">
                                <i class="bi bi-box-arrow-left fw-bold"></i><small class="px-2">Logout</small>
                            </a>
                        </div>
                    </ul>
                </div>

            </div>
        </div>
    </nav>

    <div class="container mt-2">
        <div class="card shadow-lg bg-secondary-subtle">
            <div class="card-body">

                <!-- show all messages -->
                <div class="container" id="messages">

                </div>

            </div>
            <div class="container p-2">
                <div class='text-center fs-9' id="errorMessage" style="color: red; display: none;">Please enter a message.</div>
                <div class="input-group">
                    <input type="text" id="messageInput" class="form-control fs-9" placeholder="Type your message here..." required>
                    <button class="btn btn-dark btn-lg" id="btnSendMessage"><i class="bi bi-send"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- script -->
    <script>
        //load all messages from database
        $(document).ready(function() {
            $.post('includes/messages.php', {}, function(data) {
                $("#messages").html(data);
            });
        });



        //send message and reload
        <?php echo 'let id = "' . $getUserid . '";'; ?>
        $(document).ready(function() {
            function sendMessage() {
                let message = $("#messageInput").val();

                let sanitizedMessage = $("<div>").text(message).html();

                // Check if the sanitized message is empty
                if (sanitizedMessage.trim() === "") {
                    $("#errorMessage").show();
                    return;
                }

                $.post("includes/send-message.php", {
                    message: sanitizedMessage,
                    id: id
                }, function() {
                    $("#messageInput").val("");
                });
            }

            function updateMessages() {
                $.post('includes/messages.php', {}, function(data) {
                    $("#messages").html(data);
                    setTimeout(updateMessages, 500); // Poll again after 0.5 second
                });
            }

            $("#btnSendMessage").on("click", function() {
                sendMessage();
            });

            $("#messageInput").on("input", function() {
                $("#errorMessage").hide(); // Hide the error message
            });

            // Initial call to load messages
            updateMessages();
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</body>

</html>