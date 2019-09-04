<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$page_title = "Homepage";

include "header.php";
?>


<?php include "navbar.php"; ?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-6 mx-auto">
            <?php


            if (isset($_SESSION["user_id"])); {

                $first_name = $_SESSION["first_name"];
                $last_name = $_SESSION["last_name"];
                ?>

            <h3>Welcome back, <?php echo "$first_name $last_name"; ?> </h3>

            <?php
            }

            ?>
            <br> <br>
            <br> <br>
            <br> <br>
            <a class="btn btn-primary" href="courses.php">Go to Courses</a>
            <a class="btn btn-primary" href="add_courses.php">Create a Course</a>
            <a class="btn btn-primary" href="profile.php">Update Profile</a>
        </div>
    </div>
</div>


<?php
include "footer.php";
?>