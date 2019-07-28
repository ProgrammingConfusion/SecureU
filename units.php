<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Units";

// Code for page goes here





include "header.php";
?>
<!-- page specific styling goes here -->

<?php include "navbar.php"; ?>

<!-- content for the page starts here -->

<div class="container">

    <?php


    require "db_connect.php";

    $sql = "SELECT * FROM units WHERE course_id=5";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $unit_id = $row["unit_id"];
            $unit_num = $row["unit_num"];
            $unit_name = $row["unit_name"];
            $unit_desc = $row["unit_desc"];
            $unit_type = $row["unit_type"];
            $course_id = $row["course_id"];
            ?>

            <div class="card">
                <div class="card-body ">
                    <h3 class="card-title"><?php echo $unit_name; ?></h3>
                    <p class="card-text"> <?php echo $unit_desc; ?></p>
                    <a class="btn btn-primary" href="">Select</a>

                </div>
            </div>

            <br>
            <br>
        <?php

        }
    } else {
        echo "0 results";
    }
    ?>
</div>