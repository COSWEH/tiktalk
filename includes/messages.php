    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/globalStyle.css">



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
        ?>

            <?php
            $formattedTime = date("g:i a", strtotime($getTime));

            if ($gender == "male") {
                $getGenderIcon = "<i class='bi bi-gender-male fs-9'></i>";
            } else {
                $getGenderIcon = "<i class='bi bi-gender-female fs-9'></i>";
            }
            ?>

            <div class="card border-dark ms-auto rounded-4">
                <div class="card-body">
                    <h6><?php echo $username . " " . $getGenderIcon; ?></h6>
                    <p class="card-text fs-6" style="font-family: Roboto;">
                        <?php echo "$message "; ?>
                    </p>
                </div>
            </div>
            <p class='fs-9 ms-auto'><?php echo "$formattedTime "; ?></p>
            <hr>

        <?php
        }
        ?>

    </div>